var $$ = $j.fn;

$$.extend({
  SplitID : function()
  {
    return this.attr('id').split('-').pop();
  },

  Slideshow : {
    Ready : function()
    {
      $j('div.tmpSlideshowControl')
        .hover(
          function() {
            $j(this).addClass('tmpSlideshowControlOn');
          },
          function() {
            $j(this).removeClass('tmpSlideshowControlOn');
          }
        )
        .click(
          function() {
            $$.Slideshow.Interrupted = true;

            $j('div.tmpSlide').hide();
            $j('div.tmpSlideshowControl').removeClass('tmpSlideshowControlActive');

            $j('div#tmpSlide-' + $j(this).SplitID()).show()
            $j(this).addClass('tmpSlideshowControlActive');
          }
        );

      this.Counter = 1;
      this.Interrupted = false;

      this.Transition();
    },

    Transition : function()
    {
      if (this.Interrupted) {
        return;
      }

      this.Last = this.Counter - 1;

      if (this.Last < 1) {
        this.Last = 3;
      }

      $j('div#tmpSlide-' + this.Last).fadeOut(
        'slow',
        function() {
          $j('div#tmpSlideshowControl-' + $$.Slideshow.Last).removeClass('tmpSlideshowControlActive');
          $j('div#tmpSlideshowControl-' + $$.Slideshow.Counter).addClass('tmpSlideshowControlActive');
          $j('div#tmpSlide-' + $$.Slideshow.Counter).fadeIn('slow');

          $$.Slideshow.Counter++;

          if ($$.Slideshow.Counter > 3) {
            $$.Slideshow.Counter = 1;
          }

          setTimeout('$$.Slideshow.Transition();', 6000);
        }
      );
    }
  }
});

$j(document).ready(
  function() {
    $$.Slideshow.Ready();
  }
);