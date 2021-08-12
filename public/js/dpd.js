$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

function cloneModal($idModal){
  console.log($idModal);
  $('#uiModalInstance').remove();
  $('.modal-backdrop').remove();

  let $modal = $idModal.clone().appendTo('body');
  $modal.attr('id', 'uiModalInstance');

  return $modal;
}

function deleteModal(){
  $modal = cloneModal($('#appModal'));
}

function sweetAlert(type, title, text){
  return Swal.fire({
    icon: type,
    title: title,
    text: text
  })
}

$('body')
  .on('click', '[delete-action]', function (e){
    e.preventDefault();
    const href = $(this).attr('delete-action');
    const title = $(this).attr('delete-title');
    const message = $(this).attr('delete-message');
    const $table = $(this).closest('table');

    // Enables modal on current element.
    $(this).attr('data-toggle', 'modal');
    $(this).attr('data-target', '#uiModalInstance');

    let $modal = cloneModal($('#appModal'));
    $modal.on('show.bs.modal', function (){
      // Draws text.
      $modal.find('.modal-title').html(title).css('color', 'white').parent().css('background', '#ec4561');;
      $modal.find('.modal-body').html('<span class="badge bg-danger"><i class="ti-help"></i></span>&nbsp;' + message);

      // Shows and attaches click event.
      $modal.find('.modal-action-delete').removeClass('d-none')
        .click(function (){
          $modal.modal('hide');
          $.ajax({
            url: href,
            type: 'DELETE',
            success: function(data) {
              if (!data) return;

              if(data.status == 'success')
                $table.DataTable().ajax.reload();

              sweetAlert(
                data.status,
                data.action,
                data.messages,
              );
            },
            error: function (e){
              sweetAlert(
                'error',
                'Kesalahan!',
                'Tidak dapat memproses perintah hapus!',
              );
            }
          });
        });
      }).modal('show');
    });