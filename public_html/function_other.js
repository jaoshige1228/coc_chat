$(function(){
  // メニューウィンドウのトグル
  $('.invisible').remove();
  $('.btn_mypage').click(function(){
    $('.mypage_menu').toggle();
    if(!$('.createRoomWindow').css('display','none')){
      $('.createRoomWindow').hide();
    }
  });

  // 部屋作成ウィンドウのトグル
  $('.mypage_menu').on('click','.createRoomWindowOpen',function(){
    $('.createRoomWindow').toggle();
  });

  // 部屋作成処理
  $('.createRoomButton').on('click',function(){
    $.post('/calculation.php',{
      roomName: $('.roomName').val(),
    },function(data){
      if(data == ''){
        window.location.href = 'index.php';
      }else{
        $('.errorMessage').html(data);
        $('.createRoomWindow').hide();
        $('.mypage_menu').hide();
        $('.errorMessage').fadeOut(2000);
      }
    });
  });

  // 技能表のアコーディオン
  $('.btn_wrap_skillTable').click(function(){
    if($('.wrap_skillTable').css('display') == "none"){
      $('.btn_wrap_skillTable').text('技能一覧 ▲');
      $('.wrap_skillTable,.btn_skillTable').show();
      $('.btn_skillTable').css('display','block');

    }else{
      $('.btn_wrap_skillTable').text('技能一覧 ▼');
      $('.wrap_skillTable,.btn_skillTable').hide();
    }
  });
  $("button.btn_skillTable").click(function(){
    if($(this).next().css('display') == "none"){
      $(this).next().show();
      $(this).children().text('▲');
    }else{
      $(this).children().text('▼');
      $(this).next().hide();
    }
  });
  
});