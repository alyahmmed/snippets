var total_pages,
  current_page;

function get_posts(page, refresh) {
  // Validate page
  if (page < 1 || (total_pages ? page > total_pages : false) ||
    (refresh ? false : page == current_page)) {
    return false;
  }
  var posts = $('table.posts tbody');
  if (! posts) {return false;}
  posts.html('');
  // Ajax call
  var data = {page: page};
  $.ajax({url: 'api/posts', data: data,
    success: function(response, status){
      if (response.data) {
        // Update paging vars
        current_page = response.current_page;
        total_pages = Math.ceil(response.total/response.per_page);
        // Render paging
        render_paging()
        $(response.data).each(function(i, post){
          // build row HTML
          var post_details = $('#post_details').clone().
            find('.post-show').html(post.body);
          var post_actions = $('#post_actions').clone().show();
          var post_row = $('<tr/>').
            append($('<td/>').addClass('col-md-8').
            html(post_details)).
            append($('<td/>').addClass('col-md-4').
            html(post_actions));
          post_row.find('[data-post]').data('post', post.id);
          posts.append(post_row);

          // Show post
          post_row.find('.post-show').click(function() {
            var post_id = $(this).data('post');
            $.ajax({url: 'api/posts/'+post_id,
              success: function(post, status){
                if (post.id) {
                  show_post(post);
                }  
              }
            });
            return false;
          });

          // Edit post
          post_row.find('.post-edit').click(function() {
            edit_post($(this).data('post'));
            return false;
          });

          // Delete post
          post_row.find('.post-delete').click(function() {
            var post_id = $(this).data('post');
            var flag = confirm("Confirm delete?");
            if (flag) $.ajax({url: 'api/posts/'+post_id,
              type: 'delete', success: function(response, status){
                get_posts();
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
    get_posts(1); return false;
  });
  pagination.append(first);
  
  var prev = $('<li/>').html('<a href="#">&lsaquo;</a>');
  prev.click(function() {
    get_posts(current_page-1); return false;
  });
  pagination.append(prev);

  for (var i = 1; i <= total_pages; i++) {
    var post = $('<li/>').html('<a href="#">'+i+'</a>');
    post.data('page', i);
    post.click(function() {
      get_posts($(this).data('page')); return false;
    });
    if (current_page == i) {
      post.addClass('active');
    }
    pagination.append(post);
  }

  var next = $('<li/>').html('<a href="#">&rsaquo;</a>');
  next.click(function() {
    get_posts(current_page+1); return false;
  });
  pagination.append(next);
  
  var last = $('<li/>').html('<a href="#">&raquo;</a>');
  last.click(function() {
    get_posts(total_pages); return false;
  });
  pagination.append(last);
}

function edit_post(post_id) {
  if (post_id) {
    $.ajax({url: 'api/posts/'+post_id,
      success: function(post, status){
        if (post.id) {
          $('#editPostForm .modal-body').html($('#postFields').html());
          $('#editPostForm .post-body').html(post.body);
          $('#editPostForm').data('post-id', post_id);
          $("#editModal").modal();

          get_images(post_id, $("#editModal"));
        }  
      }
    });
  }
}

function get_images(post_id, modal) {
  if (post_id) {
    $.ajax({url: 'api/posts/'+post_id+'/images',
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

function show_post(post, modal) {
  if (post) {
    var show_modal = $("#showModal");
    show_modal.find('.modal-body').html('');
    show_modal.find('.modal-body').
      append($('<article/>').html(post.body));
    show_modal.modal();

    get_images(post.id, $("#showModal"));
  }
}

$('#newPostBtn').click(function() {
  $('#newPostForm .modal-body').html($('#postFields').html());
});

$('#newPostForm').submit(function() {
  var data = new FormData($(this)[0]);
  $.ajax({url: 'api/posts', type: 'post',
    cache: false, contentType: false, processData: false,
    data: data, success: function(post, status){
      if (post.id) {
        $('#newModal').modal('hide');
        show_post(post);
      }
      get_posts();
    }
  });
  return false;
});

$('#editPostForm').submit(function() {
  var post_id = $(this).data('post-id');
  var data = new FormData($(this)[0]);
  $.ajax({url: 'api/posts/'+post_id, type: 'post',
    cache: false, contentType: false, processData: false,
    data: data, success: function(post, status){
      if (post.id) {
        $('#editModal').modal('hide');
        show_post(post);
      }
      get_posts(current_page, true);
    }
  });
  return false;
});
