/**
 * - Global Scope JS Functions -
 */

/**
 * Get Assigned Items on Logged-in user
 */
 let getAssignedItemsForReceiving = () => {
    // Call Api Request
    $.ajax({
        type: "GET",
        url: "{{ route('user.pending.received') }}",
        dataType: "json",
        success: function (response) {
            console.log(response);fs
        }
    });
}


