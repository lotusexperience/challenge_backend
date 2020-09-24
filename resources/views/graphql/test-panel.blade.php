<!DOCTYPE html>
<html>
<head>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        #graphiql {
            height: 100vh;
        }
        .header{
            background-color: #670594;
            padding: 15px;
            width: 100%;
        }
        .appkey{
            float: right;
            font-size: 20px;
            width: 300px;
            padding: 10px;
        }
        #logo{
            width: 200px;
        }

        .card > h1 {
            font-size: 12pt;
            font-family: Roboto;
            font-weight: 300;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/graphiql/0.10.2/graphiql.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.3/fetch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.4/react.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.5.4/react-dom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/graphiql/0.11.11/graphiql.min.js"></script>
</head>
<body>

<div class="header">
    <img id="logo" src="/logo-white.png" />
    <input id="appKey" class="appkey" type="text" placeholder="JWToken" />

    <div style="display: block;">
        <button id="upload" style="background-color: #6f42c1; color: #FFF; padding: 10px; border: 0px; width: 200px; cursor: pointer;'">Upload file</button>
        <input type="file" id="inputFile" style="display: none;" />
    </div>
</div>



<div id="graphiql">Loading...</div>
<script>
    /**
     * This GraphiQL example illustrates how to use some of GraphiQL's props
     * in order to enable reading and updating the URL parameters, making
     * link sharing of queries a little bit easier.
     *
     * This is only one example of this kind of feature, GraphiQL exposes
     * various React params to enable interesting integrations.
     */
    var headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    }

    var formData = null;

    var inputFile = document.getElementById('inputFile');

    inputFile.addEventListener('change', function () {

        var fieldName = prompt('informe o nome do campo', 'file');

        inputFile.style.display = "block";
        inputFile.name = fieldName;
        inputFile.disabled = true;

        if(formData === null)
            formData = new FormData();

        debugger;

        formData.append(fieldName, inputFile.files[0], inputFile.files[0].name);
    });

    document.getElementById('upload').addEventListener('click', function () {
        inputFile.click();
    });

    // Parse the search string to get url parameters.
    var search = window.location.search;
    var parameters = {};
    search.substr(1).split('&').forEach(function (entry) {
        var eq = entry.indexOf('=');
        if (eq >= 0) {
            parameters[decodeURIComponent(entry.slice(0, eq))] =
                decodeURIComponent(entry.slice(eq + 1));
        }
    });

    // if variables was provided, try to format it.
    if (parameters.variables) {
        try {
            parameters.variables =
                JSON.stringify(JSON.parse(parameters.variables), null, 2);
        } catch (e) {
            // Do nothing, we want to display the invalid JSON as a string, rather
            // than present an error.
        }
    }

    // When the query and variables string is edited, update the URL bar so
    // that it can be easily shared
    function onEditQuery(newQuery) {
        parameters.query = newQuery;
        // updateURL();
    }

    function onEditVariables(newVariables) {
        parameters.variables = newVariables;
        // updateURL();
    }

    function onEditOperationName(newOperationName) {
        parameters.operationName = newOperationName;
        // updateURL();
    }

    function getHeaders(){

        var appKey = document.getElementById('appKey').value;

        if(appKey !== '')
            headers['Authorization'] = 'Bearer ' + appKey;

        return headers;
    }

    // function updateURL() {
    //     var newSearch = '?' + Object.keys(parameters).filter(function (key) {
    //         return Boolean(parameters[key]);
    //     }).map(function (key) {
    //         return encodeURIComponent(key) + '=' + encodeURIComponent(parameters[key]);
    //     }).join('&');
    //     history.replaceState(null, null, newSearch);
    // }

    ReactDOM.render(
        React.createElement(GraphiQL, {
            fetcher: function (graphQLParams) {

                var headers = getHeaders();

                var body = JSON.stringify(graphQLParams);

                if(formData !== null) {
                    formData.append('query', graphQLParams.query);
                    body = formData;

                    delete headers['Content-Type'];
                }

                return fetch('/graphql/test-panel', {
                    method: 'post',
                    headers: headers,
                    body: body,
                    credentials: 'include',
                }).then(function (response) {
                    return response.text();
                }).then(function (responseBody) {
                    try {
                        return JSON.parse(responseBody);
                    } catch (error) {
                        return responseBody;
                    }
                })
            },
            query: parameters.query,
            variables: parameters.variables,
            operationName: parameters.operationName,
            onEditQuery: onEditQuery,
            onEditVariables: onEditVariables,
            onEditOperationName: onEditOperationName
        }),
        document.getElementById('graphiql')
    );

</script>
</body>
</html>
