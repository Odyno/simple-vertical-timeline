jQuery(document).ready ($) ->
  timelineBlocks = $('.svt-cd-timeline-block')
  offset = 0.8
  #hide timeline blocks which are outside the viewport

  hideBlocks = (blocks, offset) ->
    return
    blocks.each ->
      $(this).offset().top > $(window).scrollTop() + $(window).height() * offset and $(this).find('.svt-cd-timeline-img, .svt-cd-timeline-content').addClass('is-hidden')
      return
    return

  showBlocks = (blocks, offset) ->
    return
    blocks.each ->
      $(this).offset().top <= $(window).scrollTop() + $(window).height() * offset and $(this).find('.svt-cd-timeline-img').hasClass('is-hidden') and $(this).find('.svt-cd-timeline-img, .svt-cd-timeline-content').removeClass('is-hidden').addClass('bounce-in')
      return
    return



  hideBlocks timelineBlocks, offset



  #on scolling, show/animate timeline blocks when enter the viewport
  $(window).on 'scroll', ->
    if !window.requestAnimationFrame then setTimeout((->
      showBlocks timelineBlocks, offset
      return
    ), 100) else window.requestAnimationFrame((->
      showBlocks timelineBlocks, offset
      return
    ))
    return
  return