// JavaScript Document
function chkform(){

 
  myReg = /^.+@.+\..{2,3}$/
  mobileReg = /^[0][9]\d{8}$/
  telcode = /^[0][2-9]{1}/
  telno = /^[1-9]{7}/
  zipno = /^\d{3}/
  
  if( $("#m_account").val() =="" || !$("#m_account").val().match(myReg)){alert('請輸入正確格式之E-mail做為帳號!'); return; }
  if( $("#m_passwd").val() == ""){alert('請輸入密碼!'); return; }
  if( $("#m_passwd").val().length < 6 ){alert('請輸入6字元以上的密碼'); return;  }
  if( $("#m_passwd_confirm").val() == ""){alert('請再次確認密碼!'); return; }
  if( $("#m_passwd_confirm").val() != $("#m_passwd").val() ){alert('密碼確認不一致，請重新輸入!'); return; }
  if( $("#m_name").val() == ""){alert('請輸入姓名!'); return; }  
  if( $("#m_mobile").val() =="" || !$("#m_mobile").val().match(mobileReg)){alert('請輸入正確之手機號碼！'); return; }
  if( $("input[name='m_agree']:checked").val() !="Y"){alert('您必須閱讀並勾選同意iWine所聲明之使用者條款才能完成註冊!'); return; }
  
  if(window.confirm('是否確定送出資料並完成註冊？')){
  $("#form1").submit();
  }else{ return; }
}
