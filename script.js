$(document).ready(function() {
    // Cargar solicitudes de amistad cuando se carga la página
    loadFriendRequests();

    // Función para cargar las solicitudes de amistad
    function loadFriendRequests() {
        $.ajax({
            url: 'get_friend_requests.php',
            method: 'GET',
            success: function(response) {
                $('#friend-requests').html(response);
            }
        });
    }

    // Manejar la aceptación de la solicitud de amistad
    $(document).on('click', '.accept-request', function() {
        var requestId = $(this).data('id');
        $.ajax({
            url: 'respond_friend_request.php',
            method: 'POST',
            data: { id: requestId, action: 'accept' },
            success: function(response) {
                loadFriendRequests(); // Recargar las solicitudes de amistad
            }
        });
    });

    // Manejar el rechazo de la solicitud de amistad
    $(document).on('click', '.reject-request', function() {
        var requestId = $(this).data('id');
        $.ajax({
            url: 'respond_friend_request.php',
            method: 'POST',
            data: { id: requestId, action: 'reject' },
            success: function(response) {
                loadFriendRequests(); // Recargar las solicitudes de amistad
            }
        });
    });
});
