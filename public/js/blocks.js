var total_pages,
  current_page;

function get_blocks(page, refresh) {
  // Validate page
  if (page < 1 || (total_pages ? page > total_pages : false) ||
    (refresh ? false : page == current_page)) {
    return false;
  }
  var blocks = $('table.blocks tbody');
  if (! blocks) {return false;}
  blocks.html('');
  // Ajax call
  var data = {page: page};
  $.ajax({url: 'api/blocks', data: data,
    success: function(response, status){
      if (response.data) {
        // Update paging vars
        current_page = response.current_page;
        total_pages = Math.ceil(response.total/response.per_page);
        // Render paging
        render_paging()
        $(response.data).each(function(i, block){
          // build row HTML
          var block_details = $('#block_details').clone().
            find('.block-show').html(block.body);
          var block_actions = $('#block_actions').clone().show();
          var block_row = $('<tr/>').
            append($('<td/>').addClass('col-md-8').
            html(block_details)).
            append($('<td/>').addClass('col-md-4').
            html(block_actions));
          block_row.find('[data-block]').data('block', block.id);
          blocks.append(block_row);

          // Show block
          block_row.find('.block-show').click(function() {
            var block_id = $(this).data('block');
            $.ajax({url: 'api/blocks/'+block_id,
              success: function(block, status){
                if (block.id) {
                  show_block(block);
                }  
              }
            });
            return false;
          });

          // Edit block
          block_row.find('.block-edit').click(function() {
            edit_block($(this).data('block'));
            return false;
          });

          // Delete block
          block_row.find('.block-delete').click(function() {
            var block_id = $(this).data('block');
            var flag = confirm("Confirm delete?");
            if (flag) $.ajax({url: 'api/blocks/'+block_id,
              type: 'delete', success: function(response, status){
                get_blocks();
              }
            });
            return false;
          });
        });
      }
    }
  });
}

function render_paging() {
  var pagination = $('ul.pagination');
  if (! pagination) {return false;}
  pagination.html('');
  if (total_pages < 1) {return false;}

  var first = $('<li/>').html('<a href="#">&laquo;</a>');
  first.click(function() {
    get_blocks(1); return false;
  });
  pagination.append(first);
  
  var prev = $('<li/>').html('<a href="#">&lsaquo;</a>');
  prev.click(function() {
    get_blocks(current_page-1); return false;
  });
  pagination.append(prev);

  for (var i = 1; i <= total_pages; i++) {
    var block = $('<li/>').html('<a href="#">'+i+'</a>');
    block.data('page', i);
    block.click(function() {
      get_blocks($(this).data('page')); return false;
    });
    if (current_page == i) {
      block.addClass('active');
    }
    pagination.append(block);
  }

  var next = $('<li/>').html('<a href="#">&rsaquo;</a>');
  next.click(function() {
    get_blocks(current_page+1); return false;
  });
  pagination.append(next);
  
  var last = $('<li/>').html('<a href="#">&raquo;</a>');
  last.click(function() {
    get_blocks(total_pages); return false;
  });
  pagination.append(last);
}

function edit_block(block_id) {
  if (block_id) {
    $.ajax({url: 'api/blocks/'+block_id,
      success: function(block, status){
        if (block.id) {
          $('#editPostForm .modal-body').html($('#blockFields').html());
          $('#editPostForm .block-body').html(block.body);
          $('#editPostForm').data('block-id', block_id);
          $("#editModal").modal();

          get_images(block_id, $("#editModal"));
        }  
      }
    });
  }
}

function get_images(block_id, modal) {
  if (block_id) {
    $.ajax({url: 'api/blocks/'+block_id+'/images',
      success: function(images, status){
        if (images) {
          for (var i = images.length - 1; i >= 0; i--) {
            var img = $('<img/>').attr('src',
              'uploads/'+images[i].filename);
            modal.find('.modal-body').append(img);
          }
        }  
      }
    });
  }
}

function show_block(block, modal) {
  if (block) {
    var show_modal = $("#showModal");
    show_modal.find('.modal-body').html('');
    show_modal.find('.modal-body').
      append($('<article/>').html(block.body));
    show_modal.modal();

    get_images(block.id, $("#showModal"));
  }
}

$('#newPostBtn').click(function() {
  $('#newPostForm .modal-body').html($('#blockFields').html());
});

$('#newPostForm').submit(function() {
  var data = new FormData($(this)[0]);
  $.ajax({url: 'api/blocks', type: 'block',
    cache: false, contentType: false, processData: false,
    data: data, success: function(block, status){
      if (block.id) {
        $('#newModal').modal('hide');
        show_block(block);
      }
      get_blocks();
    }
  });
  return false;
});

$('#editPostForm').submit(function() {
  var block_id = $(this).data('block-id');
  var data = new FormData($(this)[0]);
  $.ajax({url: 'api/blocks/'+block_id, type: 'block',
    cache: false, contentType: false, processData: false,
    data: data, success: function(block, status){
      if (block.id) {
        $('#editModal').modal('hide');
        show_block(block);
      }
      get_blocks(current_page, true);
    }
  });
  return false;
});
