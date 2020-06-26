$(function(){
  $('.invisible').remove();
  $('.btn_mypage').click(function(){
    $('.mypage_menu').toggle();
  });
  $('.char_sheet_btn').click(function(){
    $('.char_sheet').toggle();
  });

  // 技能ロール展開ボタン
  $('.skillRollStart').click(function(){
    $('.skillTypeWrap').toggle();
    $('#skillRoll').hide();
    $('.dice_box').hide();
  });
  // 通常ダイスロール展開ボタン
  $('.NormalDice').on('click',function(){
    $('.dice_box').toggle();
    $('.skillTypeWrap').hide();
    $('#skillRoll').hide();
  });
  

  // 技能系統をクリックし、その一覧を表示する処理
  $('.skillTypeButton').on('click',function(){
    $('#skillRoll').css('display','block');
    index = $('.skillTypeButton').index(this);
    $.post('/calculation.php',{
      value: $('.skillTypeButton').eq(index).html()
    },function(data){
      $('#skillRoll').html(data)
    });
  });
  

  // 技能ロールを行う処理
  $('#skillRoll').on('click','button',function(){
    index = $('.skillLButton').index(this);
    $.post('/calculation.php',{
      skillLast: $('.skillLButton').eq(index).html(),
      icon: $('.iconn').val(),
      roomId: $('.roomId').val()
    },function(data){
      // console.log(data);
      var id = data;
      var host = '/chat_room.php/?roomId=';
      var redirect = host + id;
      window.location.href = redirect;
    });
  });

  // 参加申請ウィンドウのトグル
  $('.joinRequest').on('click','button',function(){
    $('.joinRequestWindow').toggle();
  });

  // 参加申請の送信
  $('.joinRequestWindow').on('click','.joinRequestSubmit',function(){
    $.post('/calculation.php',{
      request: 'on',
      roomId: $('.roomId').val()
    },function(data){
      // 現在参加している部屋のidをゲットし、リダイレクト
      var id = data;
      var host = '/chat_room.php/?roomId=';
      var redirect = host + id;
      window.location.href = redirect;
      // console.log(data);
    });
  });

  // 参加申請者一覧リスト
  $('.kpOnlyButton').click(function(){
    $('.requestedMember').toggle();
    $('.requestedConfirm').hide();
  });

  // 参加申請者をクリックした時の確認画面
  $('.requestedMemberList').click(function(){
    var userName = $(this).html();
    $('.requestedConfirm').children('span').html(userName);
    $('.requestedConfirm').toggle();
    
  });
  
  // 参加申請者を許可する時(はいを押した時)の処理
  $('.requestedConfirm').find('button').on('click',function(){
    if($(this).html() == 'はい'){
      var userName = $('.requestedConfirm').children('span').html();
      $.post('/calculation.php',{
        userName: userName,
        roomId: $('.roomId').val()
      },function(data){
        // console.log(data);
        // 現在参加している部屋のidをゲットし、リダイレクト
        var id = data;
        var host = '/chat_room.php/?roomId=';
        var redirect = host + id;
        window.location.href = redirect;
      });
    }
  });

  // HPやSANの増減処理
  $('.modifiData').on('click','button',function(){
    // var mpUD = $('#mpUD').val();
    // console.log(mpUD);
    $.post('/calculation.php',{
      modifiData: 'on',
      hp: $('#hp').val(),
      hpUD: $('#hpUD').val(),
      mp: $('#mp').val(),
      mpUD: $('#mpUD').val(),
      san: $('#san').val(),
      sanUD: $('#sanUD').val(),
      roomId: $('.roomId').val()
    },function(data){
      // console.log(data);
      var id = data;
      var host = '/chat_room.php/?roomId=';
      var redirect = host + id;
      window.location.href = redirect;
    });
  });

  $('.modifiedHP').on('click',function(){
    $('.modifiData').toggle();
  });

  // レスポンシブ時処理
  $('#SPmenu').on('click', function(){
    $('.leftContainer').toggle();
  });
  $('#SPmenu2').on('click', function(){
    $('.rightContainer').toggle();
  });




});
