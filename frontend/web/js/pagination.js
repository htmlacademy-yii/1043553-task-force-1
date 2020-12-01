
let links = $(".pagination__item--link");
let keys = Object.keys(links);
var filteredKeys = keys.filter(function (item) {
    return (parseInt(item) == item);
});

console.log(filteredKeys);

filteredKeys.forEach(element => addOnClick(element, links));


function addOnClick(item, links) {
    let link = links[item];

    console.log(link);

    link.onclick = function (event) {
        document.getElementById('filterForm').action = event.srcElement.href;
        link.href = '#';

        console.log(document.getElementById('filterForm'));
        document.getElementById('filterForm').submit();
    };
}

