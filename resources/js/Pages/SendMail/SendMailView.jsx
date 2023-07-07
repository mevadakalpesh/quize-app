import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head,useForm} from '@inertiajs/react';
import Select from 'react-select'
import BootstrapSwitchButton from 'bootstrap-switch-button-react'
import InputError from '@/Components/InputError';
import Toster from '@/Components/Toster';
import { useState,useEffect } from 'react'
import {selectBoxKeyUpdate} from '@/Helper';

function SendMailView( { auth,flash,templates}) {
  
  const {data,setData,post,put,process,errors,reset} = useForm( {
      emails: '',
      template:null,
      status:true,
    });
   
  const hendleForm = (e) => {
      e.preventDefault();
      post(route('sendClientMail'));
  }
   
  const handleSelectChange = (selectedValues) => {
    setData('template',selectedValues);
  };
  
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
      >
      <Head title="Questions" />
      <div className="py-12">
        <h3>Send Mail</h3>
          <form onSubmit={hendleForm}>
        
          <div className="form-group">
            <lable>Emails (Ex : e1@gmail.com,e2@gmail.com)</lable>
            <input type="text" className="form-control" name="emails"
            value={data.emails} 
            onChange={(e) => setData('emails',e.target.value)}
            />
            <InputError message={errors.emails} className="mt-2" />
          </div>
          
          <div className="form-group">
            <lable>Template</lable>
            <Select
              options={selectBoxKeyUpdate(templates,'id','subject')}
              value={selectBoxKeyUpdate(data.template,'id','subject')}
              onChange={handleSelectChange}
            />
              <InputError message={errors.template} className="mt-2" />
          </div>
          
                    <div className="form-group">
            <lable>Status </lable>
            <div>
              <BootstrapSwitchButton
                  checked={data.status == 1? true : false}
                  onChange={(e) => setData('status',!data.status) }
                  onlabel='With Markdown'
                  offstyle='danger'
                  offlabel='Without Markdown'
                  onstyle='success'
                  style="w-75"
              />
            </div>
          </div>
          
           <div className="mt-3 d-flex">
               <button type="submit"  className="btn btn-info
               text-capitalize">Send Mail</button>
           </div>
           <Toster flash={flash} />
        </form>
      
      </div>
    </AuthenticatedLayout>
  );
}

export default SendMailView;