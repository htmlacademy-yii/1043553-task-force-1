<ul class="user__search-list">
    <li class="user__search-item user__search-item--current" id = 'rating'>
        <a onclick="
        document.getElementById('filterForm').action = '/users?sortBy=rating';
        document.getElementById('filterForm').submit();"
           class="link-regular">Рейтингу</a>
    </li>
    <li class="user__search-item" id = 'tasksAmount'>
        <a onclick="
        document.getElementById('filterForm').action = '/users?sortBy=tasks';
        document.getElementById('filterForm').submit();"
            class="link-regular">Числу заказов</a>
    </li>
    <li class="user__search-item" id = 'popularity'>
        <a onclick="
        document.getElementById('filterForm').action = '/users?sortBy=reviews';
        document.getElementById('filterForm').submit();"
            class="link-regular">Популярности</a>
    </li>
</ul>