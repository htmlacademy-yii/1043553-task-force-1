updateActiveTab();

function updateActiveTab()
{
    let activeTab = $(".site-list__item--active");
    let url = window.location.href;
    activeTab.toggleClass('site-list__item--active');

    if (~url.indexOf("users")) {
        $('#users').addClass('site-list__item--active');
        console.log('users');
    }
    if (~url.indexOf("tasks")) {
        $('#tasks').addClass('site-list__item--active');
        console.log('tasks');
    }
}