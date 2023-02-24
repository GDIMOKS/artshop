<?php
require_once '../../classes/user.php';

session_start();
require_once '../../config.php';
require_once '../../functions.php';

error_reporting(-1);
if (empty($_SESSION['auth']) || $_SESSION['user']->getRoleName() == 'Продавец' || $_SESSION['user']->getRoleName() == 'Гость')
{
    header('Location: /assets/pages/signin_page.php');
}
if (isset($_POST['client_action'])) {
    switch ($_POST['client_action']) {
        case 'get_data':
            $first_name = $_SESSION['user']->first_name;
            $last_name = $_SESSION['user']->last_name;
            $patronymic_name = $_SESSION['user']->patronymic_name;
            $email = $_SESSION['user']->email;
            $birthday = $_SESSION['user']->birthday;
            $phone = $_SESSION['user']->phone;


            echo json_encode(['user' =>
                ['first_name' => $first_name,
                 'last_name' => $last_name,
                 'patronymic_name' => $patronymic_name,
                 'email' => $email,
                 'birthday' => $birthday,
                 'phone'=> $phone
                ]
            ]);
            break;

        case 'edit_data':
            $user_id = $_SESSION['user']->id;
            $query = "SELECT COUNT(user_id) as total_count 
                      FROM users
                      WHERE user_id != ? AND email = ?";
            $stmt = $connection->prepare($query);
            $stmt->bind_param("is", $user_id, $_POST['email']);
            $stmt->execute();
            $is_exist = $stmt->get_result()->fetch_assoc();
            if ($is_exist['total_count'] != 0) {
                echo json_encode(['code' => 'ERROR', 'message' => 'Пользователь с таким email уже существует!']);
            } else {
                $query = "UPDATE users 
                      SET 
                        first_name=?,
                        last_name=?,
                        patronymic_name=?,
                        email=?,
                        birthday=?,
                        phone=?
                      WHERE user_id = ?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("sssssss",
                    $_POST['first_name'],
                    $_POST['last_name'],
                    $_POST['patronymic_name'],
                    $_POST['email'],
                    $_POST['birthday'],
                    $_POST['phone'],
                    $user_id
                );

                $stmt->execute();
                $result = $stmt->get_result();
                if (!$result) {
                    $query = "SELECT * FROM users WHERE user_id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $userInfo = $stmt->get_result()->fetch_assoc();

                    $user = new User($userInfo);
                    $_SESSION['user'] = $user;
                    $fullName = $_SESSION['user']->getFullName();
                    echo json_encode(['code' => 'OK', 'message'=>'Данные обновлены!', 'full_name' => $fullName, 'type' => 'edit_data']);
                } else {
                    echo json_encode(['code' => 'ERROR', 'message' => 'Пользователя не существует!']);
                }
            }


            break;

        case 'edit_password':
            $oldPassword = $_POST['old_password'];
            $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            $currentPassword = $_SESSION['user']->password;
            if (!password_verify($oldPassword, $currentPassword)) {
                echo json_encode(['code' => 'ERROR', 'message' => 'Текущий пароль не совпадает!', 'type' => 'edit_password']);
            } else {
                $query = "UPDATE users SET password=?";
                $stmt = $connection->prepare($query);
                $stmt->bind_param("s", $newPassword);
                $stmt->execute();

                $result = $stmt->get_result();
                $_SESSION['user']->password = $newPassword;

                if (!$result) {
                    echo json_encode(['code' => 'OK', 'message' => 'Пароль успешно обновлен!', 'type' => 'edit_password']);
                } else {
                    echo json_encode(['code' => 'ERROR', 'message' => 'Error!', 'type' => 'edit_password']);
                }
            }
            break;

    }
}
?>
