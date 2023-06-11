import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head,useForm} from '@inertiajs/react';
import Select from 'react-select'
import BootstrapSwitchButton from 'bootstrap-switch-button-react'
import InputError from '@/Components/InputError';
import Toster from '@/Components/Toster';
import { useState,useEffect } from 'react'
import {QuestionService} from '@/Services/Index.jsx'

function QuizeCreate( { categories,flash,form_type,quize,auth,users}) {
  
  const {data,setData,post,put,process,errors,reset} = useForm(getFormState(form_type));
  const [questions,setQuestions] = useState([]);
   function selectBoxKeyUpdate(options,key,value){
     let updateData = options.map((catdata,index) => {
       return {
          value: catdata[key] ? catdata[key] : catdata.value,
          label: catdata[value] ? catdata[value] : catdata.label ,
        }
     });
      return updateData;
   }
   function getFormState(form_type){
     if(form_type == 'add'){
       return addFormState();
     }else{
       return quize;
     }
   }
   
   function addFormState(){
       return {
        quize_name: '',
        description:'',
        expire_time:'',
        status: true,
        category:[],
        questions:[],
        users:[],
      }
   }
  
  function getQuestionByCategory(){
    
  }
  
  function hendleForm(e){
    e.preventDefault();
    if(form_type == 'edit' && quize && quize.id){
      put(route('quize.update',quize.id));
    }else{
      post(route('quize.store'),{
          onSuccess: () => {
              reset();
          }
      });
    }
  }
  
  useEffect(() => {
    QuestionService.getQuestionByCategory({category:selectBoxKeyUpdate(data.category,'id','name')}).then(response => {
      if(response.data.code == 200){
       setQuestions(response.data.result);
      }
    })
    .catch(error => {
      console.error(error);
    });
  },[data.category])
  
  const handleCategoryChange = (selectedValues) => {
    setData('category',selectedValues);
  };
  
  const handleQuestionChange = (selectedValues) => {
    setData('questions',selectedValues);
  };
  
  const handleUserChange = (selectedValues) => {
    setData('users',selectedValues);
  };
  
  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
      >
      <Head title="Questions" />
      <div className="py-12">
        <h3>Quize {form_type}</h3>
        <form onSubmit={hendleForm}>
        
          <div className="form-group">
            <lable>Title</lable>
            <input type="text" className="form-control" name="quize_name"
            value={data.quize_name} 
            onChange={(e) => setData('quize_name',e.target.value)}
            />
            <InputError message={errors.quize_name} className="mt-2" />
          </div>
        
          <div className="form-group">
            <lable>Expire Time (Min)</lable>
            <input type="text" className="form-control" name="expire_time"
            value={data.expire_time} 
            onChange={(e) => setData('expire_time',e.target.value)}
            />
            <InputError message={errors.expire_time} className="mt-2" />
          </div>
        
          <div className="form-group">
            <lable>Description</lable>
            <textarea 
            name="description"
            className="form-control"
            onChange={(e) => setData('description',e.target.value) }>{data.description}</textarea>
            <InputError message={errors.description} className="mt-2" />
          </div>
          
          <div className="form-group">
            <lable>Categories</lable>
            <Select
              options={selectBoxKeyUpdate(categories,'id','name')}
              isMulti
              value={selectBoxKeyUpdate(data.category,'id','name')}
              onChange={handleCategoryChange}
            />
          </div>
          
          <div className="form-group">
            <lable>Questions</lable>
            <Select
              options={selectBoxKeyUpdate(questions,'id','question_name')}
              isMulti
              value={selectBoxKeyUpdate(data.questions,'id','question_name')}
              onChange={handleQuestionChange}
            />
          </div>
          
          <div className="form-group">
            <lable>User</lable>
            <Select
              options={selectBoxKeyUpdate(users,'id','name')}
              isMulti
              value={selectBoxKeyUpdate(data.users,'id','name')}
              onChange={handleUserChange}
            />
          </div>
          
          
          <div className="form-group">
            <lable>Status </lable>
            <div>
              <BootstrapSwitchButton
                  checked={data.status == 1? true : false}
                  onChange={(e) => setData('status',!data.status) }
                  onlabel='Active'
                  offstyle='danger'
                  offlabel='Deactive'
                  onstyle='success'
                  style="w-25"
              />
            </div>
          </div>
          
           <div className="mt-3 d-flex">
               <button type="submit" className="btn btn-info text-capitalize">{form_type}</button>
           </div>
           <Toster flash={flash} />
        </form>
      </div>
    </AuthenticatedLayout>
  );
}

export default QuizeCreate;