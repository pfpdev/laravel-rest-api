<!DOCTYPE html>
<html>
<head>
    <title>Laravel REST API ver. 1.0.0</title>
    <link href="https://unpkg.com/swagger-ui-dist/swagger-ui.css" rel="stylesheet" />
</head>
<body>
<div id="swagger-ui"></div>
<script src="https://unpkg.com/swagger-ui-dist/swagger-ui-bundle.js"></script>
<script>
    SwaggerUIBundle({
        url: '/api-docs-v1.yaml',
        dom_id: '#swagger-ui',
        requestInterceptor: function (request) {
            request.headers['accept'] = 'application/json';
            return request;
        }
    });
</script>
</body>
</html>
