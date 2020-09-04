updateActiveTab();
updateActiveUserSearchFiler();

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

    if (~url.indexOf("account")) {
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