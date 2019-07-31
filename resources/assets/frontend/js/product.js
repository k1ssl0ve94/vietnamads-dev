$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    arrows: true,
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    variableWidth: true
});
$('.box-top-titles').slick({
    slidesToShow: 1,
    slidesToScroll: -1,
    arrows: false,
    slidesToShow: 7,
    slidesToScroll: 1,
    vertical: true,
    autoplay: true,
    autoplaySpeed: 2000
});

var topPost = $('#box-top-content .top-post').first();

$('.box-top-titles').on('afterChange', function(event, slick, currentSlide) {
    var data = window.hot_post_data[currentSlide];
    topPost.find('> a').attr('href', data.url).attr('title', data.title);
    topPost.find('> a > img').attr('src', data.image_url).attr('title', data.title);
    topPost.find('.content a.title').text(data.title_short).attr('href', data.url);
    topPost.find('.content p').text(data.sapo_short);
});
