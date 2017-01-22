/*
* Class: warnUnload
* Use: Warn user if data is unsaved when they try to browse away from current page
* Author: Carl Furrow (http://carlfurrow.com)
* Version: 0.1.0
*/
/*global opera:true */
(function($){
  if(typeof $ === "undefined" || $ === null){
    return;
  }

  function addIgnoreWarnToIgnore(options){
    if(options.ignore === null || options.ignore === ""){
      options.ignore = ".ignore-warn";
    }
    if(!/\.ignore-warn/.test(options.ignore)){
      options.ignore += ", .ignore-warn";
    }
  }

  $.warnUnload = function(options){
    var DEFAULTS = {
      message:'Are you sure you want to leave this page?',
      urls:[],
      ignore:".ignore-warn",
      after:function(){},
      onItem:function(item){return true;}};
    options = $.extend(DEFAULTS,options);
    addIgnoreWarnToIgnore(options);
    var $inputs = $("input:text,input:hidden,input:checkbox,input:radio,input[type = number],select");

    try{
      // http://www.opera.com/support/kb/view/827/
      opera.setOverrideHistoryNavigationMode('compatible');
      history.navigationMode = 'compatible';
    }catch(e){}

    function setupChangeEventsOnInputs(){
      $inputs.change(markAsChanged);
    }

    function markAsChanged(){
      $(this).attr("data-changed","true");
    }

    function checkInputs(){
      var warn = false;
      $inputs.each(function(index,input){
        var $input = $(input);
        if($input.attr("data-changed") === "true" && options.onItem($input)){
          warn = true;
          return;
        }
      });
      return warn;
    }

    function doWeShowConfirmMessage(){
      var warn = false;
      // only show message if url matches location.href
      if(options.urls && options.urls.length > 0){
        $.each(options.urls,function(index,url){
          if(location.href.indexOf(url) > 0){
            warn = checkInputs();
          }
        });
      }
      else{
        warn = checkInputs();
      }

      if(warn){
        options.after();
        return returnMessage();
      }
      return;
    }

    function returnMessage()
    {
      return options.message;
    }

    function unBindWindow()
    {
      $(window).unbind('beforeunload', doWeShowConfirmMessage);
    }

    function unBindIgnores(){
      $(options.ignore).bind('click', unBindWindow);
    }

    //Bind Exit Message Dialogue
    setupChangeEventsOnInputs();
    unBindIgnores();

    $(window).bind('beforeunload', doWeShowConfirmMessage);
  };
})(jQuery);