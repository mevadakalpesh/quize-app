import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head,useForm} from '@inertiajs/react';
import InputError from '@/Components/InputError';
import Toster from '@/Components/Toster';
import { useState,useEffect } from 'react'

const addFormState = () => {
    return {subject: '',body:''}
}

function CreateOrUpdateTemplate( { auth,flash,form_type,template}) {
  
  const formState = form_type == 'edit' && template ? template : addFormState();
  const {data,setData,post,put,process,errors,reset} = useForm(formState);
  const hendleForm = (e) => {
    e.preventDefault();
    if(form_type == 'edit' && template && template.id){
      put(route('templates.update',template.id));
    }else{
      post(route('templates.store'),{
          onSuccess: () => {
              reset();
          }
      });
    }
  }
   
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
      >
      <Head title="Templates" />
      <div className="py-12">
        <h3>Template {form_type}</h3>
          <form onSubmit={hendleForm}>
        
          <div className="form-group">
            <lable>Subject</lable>
            <input type="text" className="form-control" name="subject"
            value={data.subject} 
            onChange={(e) => setData('subject',e.target.value)}
            />
            <InputError message={errors.subject} className="mt-2" />
          </div>
        
          <div className="form-group">
            <lable>Body</lable>
            <textarea 
            name="body"
            className="form-control"
            rows="20"
            value={data.body ?? ' '}
            onChange={(e) => setData('body',e.target.value)
            }></textarea>
            <InputError message={errors.body} className="mt-2" />
          </div>
           <div className="mt-3 d-flex">
               <button type="submit"  className="btn btn-info text-capitalize">{form_type}</button>
           </div>
           <Toster flash={flash} />
        </form>
      
      </div>
    </AuthenticatedLayout>
  );
}

export default CreateOrUpdateTemplate;