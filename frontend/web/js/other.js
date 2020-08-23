updateActiveTab();

function updateActiveTab()
{
    var url = window.location.href.split('/');
    var currentRoute = url.pop() || url.pop();  // handle potential trailing slash

    let activeTab = $(".site-list__item--active");
    activeTab.toggleClass('site-list__item--active');
    $('#' + currentRoute).addClass('site-list__item--active');
}