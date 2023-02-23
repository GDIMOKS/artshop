function get_current_time(element_selector)  {
    let date = new Date();
    let options = {
        weekday: "long",
        year: "numeric",
        month: "numeric",
        day: "numeric",
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric'
    };

    $(element_selector).text(date.toLocaleDateString("ru", options));
}

function display_current_time(element_selector) {
    let now = new Date();
    setInterval(get_current_time, 1000, element_selector);
}

display_current_time('.current_time');