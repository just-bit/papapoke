jQuery(function($){
  var batch = 3;
  var loading = false;
  var $globalLoader = $('<div class="papa-loader" style="display:none"></div>').appendTo('body'); // fallback if CSS missing

  $(window).on('scroll', function(){
    if(loading) return;

    var $container = $('.menu-sec-container:visible');
    if(!$container.length) return;

    if($container.data('done')) return;

    var $list = $container.find('ul.products');
    if(!$list.length) return;

    var listBottom = $list.offset().top + $list.outerHeight();
    var scrollBottom = $(window).scrollTop() + $(window).height();

    // If we scrolled within 150px of the list bottom, load more
    if(scrollBottom + 150 < listBottom){
      return;
    }

    loading = true;

    // Show loader
    var $loader = $container.find('.papa-loader');
    if(!$loader.length){
      $loader = $('<div class="papa-loader"></div>').appendTo($container);
    }
    $loader.show();

    var tab    = $container.attr('id');
    var offset = $list.find('li.product').length;

    $.post(papaLoadMore.ajaxurl, {
      action: 'papa_load_more_products',
      nonce:  papaLoadMore.nonce,
      tab:    tab,
      offset: offset
    }, function(response){
      if($.trim(response)){
        var $items = $(response);
        $list.append($items);
        if($items.length < batch){
          $container.data('done', true);
        }
      } else {
        $container.data('done', true);
      }
    }).always(function(){
      $container.find('.papa-loader').hide();
      loading = false;
    });
  });
});
