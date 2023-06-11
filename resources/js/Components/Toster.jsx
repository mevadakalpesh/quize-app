import { ToastContainer, toast } from 'react-toastify';
import { useState,useEffect } from 'react'
function Toster ({flash}) {
  useEffect(() => {
    if(flash && flash.success){
    showToastMessage(flash.success,'success');
  } else if(flash &&  flash.error){
    showToastMessage(flash.error,'error');
  }
  }, [flash]);
  const showToastMessage = (msg,type) => {
          switch (type) {
            case 'success':
              toast.success(msg, {position: toast.POSITION.TOP_RIGHT});
              break;
            case 'error':
              toast.error(msg, {position: toast.POSITION.TOP_RIGHT});
              break;
            case 'warning':
              toast.warning(msg, {position: toast.POSITION.TOP_RIGHT});
              break;
            default:
            toast.info(msg, {position: toast.POSITION.TOP_RIGHT});
              break;
           }
    };
  return (
      <>
         <ToastContainer />
      </>
  )
}
export default Toster;