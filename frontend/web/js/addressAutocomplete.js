$(document).ready(function () {
    new autoComplete({
        data: {                              // Data src [Array, Function, Async] | (REQUIRED)
            src: async () => {
                // API key token
                const token = "";
                // User search query
                const query = document.querySelector("#address").value;
                // Fetch External Data Source
                const source = await fetch(`/autocomplete?address=${query}`);
                // Format data into JSON
                const data = await source.json();

                console.log(data);

                //console.log(document.querySelector("#address"));

                // Return Fetched data
                return data;
            },
            key: ["address"],
            cache: false
        },
        placeHolder: "Место задания...",       // Place Holder text                 | (Optional)
        selector: "#address",                  // Input field selector              | (Optional)
        threshold: 3,                          // Min. Chars length to start Engine | (Optional)
        debounce: 1000,                        // Post duration for engine to start | (Optional)
        searchEngine: "strict",                // Search Engine type/mode           | (Optional)
        resultsList: {                         // Rendered results list object      | (Optional)
            render: true,
            container: source => {
                source.setAttribute("id", "address_list");
            },
            destination: document.querySelector("#address"),
            position: "afterend",
            element: "ul"
        },
        maxResults: 5,                         // Max. number of rendered results | (Optional)
        highlight: true,                       // Highlight matching results      | (Optional)
        resultItem: {                          // Rendered result item            | (Optional)
            content: (data, source) => {
                source.innerHTML = data.match;
            },
            element: "li"
        },
        noResults: () => {                     // Action script on noResults      | (Optional)
            const result = document.createElement("li");
            result.setAttribute("class", "no_result");
            result.setAttribute("tabindex", "1");
            result.innerHTML = "Место не найдено";
            document.querySelector("#address_list").appendChild(result);
        },
        onSelection: feedback => {             // Action script onSelection event | (Optional)
            document.querySelector("#address").value = feedback.selection.value["address"];
            console.log(parseFloat(feedback.selection.value.coordinates.lat));
            document.querySelector("#taskcreateform-lat").value = parseFloat(feedback.selection.value.coordinates.lat);
            document.querySelector("#taskcreateform-lon").value = parseFloat(feedback.selection.value.coordinates.lon);
        }
    });
});
