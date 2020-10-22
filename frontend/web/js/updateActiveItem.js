updateActiveTab();
updateActiveUserSearchFiler();
updateActiveTaskStatusFiler();

function updateActiveTab()
{
    let activeTab = $(".site-list__item--active");
    let url = window.location.href;
    activeTab.toggleClass('site-list__item--active');

    if (~url.indexOf("create")) {
        $('#create').addClass('site-list__item--active');
        return ;
    }

    if (~url.indexOf("user")) {
        $('#users').addClass('site-list__item--active');
        return ;
    }
    if (~url.indexOf("task")) {
        $('#tasks').addClass('site-list__item--active');
        return ;
    }

    if (~url.indexOf("profile")) {
        $('#account').addClass('site-list__item--active');
    }
}

function updateActiveUserSearchFiler()
{
    let activeTab = $(".user__search-item--current");
    activeTab.toggleClass('user__search-item--current');
    let url = window.location.href;

    if (~url.indexOf("sortBy=tasks")) {
        $('#tasksAmount').addClass('user__search-item--current');
    }
    if (~url.indexOf("sortBy=rating")) {
        $('#rating').addClass('user__search-item--current');
    }
    if (~url.indexOf("sortBy=reviews")) {
        $('#popularity').addClass('user__search-item--current');
    }
}

function updateActiveTaskStatusFiler()
{
    let activeTab = $(".menu_toggle__item--current");
    activeTab.toggleClass('menu_toggle__item--current');
    let url = window.location.href;

    if (~url.indexOf("new")) {
        $('#new').addClass('menu_toggle__item--current');
        return
    }
    if (~url.indexOf("processing")) {
        $('#active').addClass('menu_toggle__item--current');
        return
    }
    if (~url.indexOf("accomplished")) {
        $('#completed').addClass('menu_toggle__item--current');
        return
    }
    if (~url.indexOf("cancelled")) {
        $('#cancelled').addClass('menu_toggle__item--current');
        return
    }
    if (~url.indexOf("failed")) {
        $('#failed').addClass('menu_toggle__item--current');
        return
    }
    $('#active').addClass('menu_toggle__item--current');
}