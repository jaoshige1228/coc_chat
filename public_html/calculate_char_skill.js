$(function(){
  // 技能ポイント自動計算
  $('.keyUp').keyup(function(){
    var classVal = $(this).attr('class');
    var classVals = classVal.split(' ');
    var test = '.' + classVals[0];
    var index = $(test).index(this);
    var type = $(this).parents('tr').attr('id');
    if(type == 'fight'){
      fight_cal(index);
    }else if(type == 'find'){
      find_cal(index);
    }else if(type == 'act'){
      act_cal(index);
    }else if(type == 'neg'){
      neg_cal(index);
    }else if(type == 'know'){
      know_cal(index);
    }
  });

  // ダメージボーナス手動計算
  $('#cal_db').click(function(){
    $.get('calculation.php',{
      str: $('.str').val(),
      siz: $('.siz').val()
    },function(data){
      $('.db').val(data);
    });
  });

  // 職業技能点 & 知識自動計算
  $('.edu').keyup(function(){
    var jobP = ($('.edu').val())*20;
    var knowledge = ($('.edu').val())*5;
    if(knowledge >= 100){
      var knowledge = 99;
    }
    $('.jobP').val(jobP);
    $('.knowledge').val(knowledge);

    // 母国語自動計算
    var native = ($('.edu').val())*5;
    $('.iniP_neg').eq(4).val(native);
    $('.sumP_neg').eq(4).val(native);
  });

  // 趣味技能点 & アイデア自動計算
  $('.int').keyup(function(){
    var hobP = ($('.int').val())*10;
    var idea = ($('.int').val())*5;
    if(idea >= 100){
      var idea = 99;
    }
    $('.hobP').val(hobP);
    $('.idea').val(idea);
  });

  // 幸運 & SAN & MP自動計算
  $('.pow').keyup(function(){
    var luck = ($('.pow').val())*5;
    var san = ($('.pow').val())*5;
    var mp = $('.pow').val();
    if(luck >= 100){
      var luck = 99;
    }
    if(san >= 100){
      var san = 99;
    }
    $('.san').val(san);
    $('.luck').val(luck);
    $('.mp').val(mp);
  });

  // 回避初期値自動計算
  $('.dex').keyup(function(){
    var avo = ($('.dex').val())*2;
    $('.iniP_fight').eq(0).val(avo);
    $('.sumP_fight').eq(0).val(avo);
  });

  // HP自動計算
  $('.hp').focus(function(){
    var con = parseInt($('.con').val());
    var siz = parseInt($('.siz').val());
    if(isNaN(con) || isNaN(siz)){
      con = 0;
      siz = 0;
    }
    var hp = Math.ceil((con + siz)/2);
    $('.hp').val(hp);
  });

  // 入力中の職業技能点の合計を計算
  $('.input_jobP').on('keyup',function(){
    var length = $('.input_jobP').length;
    var sum = 0;
    for(var i = 0;i < length;i++){
      if(isNaN(parseInt($('.input_jobP').eq(i).val()))){
        temp = 0;
      }else{
        temp = parseInt($('.input_jobP').eq(i).val());
      }
      sum += temp;
    }
    $('.sum_jobP').val(sum);
    // 職業技能点がEDU✖︎20を超えた場合、入力欄を赤色に
    var sum_jobP = parseInt($('.sum_jobP').val());
    var jobP = parseInt($('.jobP').val());
    if(sum_jobP > jobP){
      $('.sum_jobP').css('background-color','tomato');
    }else{
      $('.sum_jobP').css('background-color','white');
    }
  });

  // 入力中の趣味技能点の合計を計算
  $('.input_hobP').on('keyup',function(){
    var length = $('.input_hobP').length;
    var sum = 0;
    for(var i = 0;i < length;i++){
      if(isNaN(parseInt($('.input_hobP').eq(i).val()))){
        temp = 0;
      }else{
        temp = parseInt($('.input_hobP').eq(i).val());
      }
      sum += temp;
    }
    $('.sum_hobP').val(sum);

    // 趣味技能点がEDU✖︎20を超えた場合、入力欄を赤色に
    var sum_jobP = parseInt($('.sum_hobP').val());
    var jobP = parseInt($('.hobP').val());
    if(sum_jobP > jobP){
      $('.sum_hobP').css('background-color','tomato');
    }else{
      $('.sum_hobP').css('background-color','white');
    }
  });

  // 入力中の成長点の合計を裏で計算
  $('.input_etcP').on('keyup',function(){
    var length = $('.input_etcP').length;
    var sum = 0;
    for(var i = 0;i < length;i++){
      if(isNaN(parseInt($('.input_etcP').eq(i).val()))){
        temp = 0;
      }else{
        temp = parseInt($('.input_etcP').eq(i).val());
      }
      sum += temp;
    }
    $('.sum_etcP').val(sum);
  });

  // 関数(技能ポイント計算に用いる)
  function fight_cal(index){
    var jobPoint = parseInt($('.jobP_fight').eq(index).val());
    var hobPoint = parseInt($('.hobP_fight').eq(index).val());
    var etcPoint = parseInt($('.etcP_fight').eq(index).val());
    var iniPoint = parseInt($('.iniP_fight').eq(index).val());
    var sum = sumPoint(jobPoint,hobPoint,etcPoint,iniPoint);
    return $('.sumP_fight').eq(index).val(sum);
  }
  function find_cal(index){
    var jobPoint = parseInt($('.jobP_find').eq(index).val());
    var hobPoint = parseInt($('.hobP_find').eq(index).val());
    var etcPoint = parseInt($('.etcP_find').eq(index).val());
    var iniPoint = parseInt($('.iniP_find').eq(index).val());
    var sum = sumPoint(jobPoint,hobPoint,etcPoint,iniPoint);
    return $('.sumP_find').eq(index).val(sum);
  }
  function act_cal(index){
    var jobPoint = parseInt($('.jobP_act').eq(index).val());
    var hobPoint = parseInt($('.hobP_act').eq(index).val());
    var etcPoint = parseInt($('.etcP_act').eq(index).val());
    var iniPoint = parseInt($('.iniP_act').eq(index).val());
    var sum = sumPoint(jobPoint,hobPoint,etcPoint,iniPoint);
    return $('.sumP_act').eq(index).val(sum);
  }
  function neg_cal(index){
    var jobPoint = parseInt($('.jobP_neg').eq(index).val());
    var hobPoint = parseInt($('.hobP_neg').eq(index).val());
    var etcPoint = parseInt($('.etcP_neg').eq(index).val());
    var iniPoint = parseInt($('.iniP_neg').eq(index).val());
    var sum = sumPoint(jobPoint,hobPoint,etcPoint,iniPoint);
    return $('.sumP_neg').eq(index).val(sum);
  }
  function know_cal(index){
    var jobPoint = parseInt($('.jobP_know').eq(index).val());
    var hobPoint = parseInt($('.hobP_know').eq(index).val());
    var etcPoint = parseInt($('.etcP_know').eq(index).val());
    var iniPoint = parseInt($('.iniP_know').eq(index).val());
    var sum = sumPoint(jobPoint,hobPoint,etcPoint,iniPoint);
    return $('.sumP_know').eq(index).val(sum);
  }
  

  function sumPoint(jobPoint,hobPoint,etcPoint,iniPoint){
    if(isNaN(jobPoint)){
      jobPoint = 0;
    }
    if(isNaN(hobPoint)){
      hobPoint = 0;
    }
    if(isNaN(etcPoint)){
      etcPoint = 0;
    }
    if(isNaN(iniPoint)){
      iniPoint = 0;
    }
    var sum = (jobPoint + hobPoint + etcPoint + iniPoint);
    return sum;
  }


});