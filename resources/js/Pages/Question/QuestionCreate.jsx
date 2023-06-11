import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head,useForm} from '@inertiajs/react';
import Select from 'react-select'
import BootstrapSwitchButton from 'bootstrap-switch-button-react'
import InputError from '@/Components/InputError';
import Toster from '@/Components/Toster';
import { useState,useEffect } from 'react'


function QuestionCreate( { auth,categories,flash,form_type,question}) {
  const optionTag = ['A','B','C','D'];
  const {data,setData,post,put,process,errors,reset} = useForm(getFormState(form_type));
  const [setButtonType,buttonType] = useState();
   function selectBoxKeyUpdate(options){
     let updateData =   options.map((catdata,index) => {
       return {
          value: catdata.id ? catdata.id : catdata.value,
          label: catdata.name ? catdata.name : catdata.label ,
        }
     });
      return updateData;
   }
   function getFormState(form_type){
     if(form_type == 'add'){
       return addFormState();
     }else{
       return [...question,{buttonType:''}];
     }
   }
   
   function addFormState(){
     return {
      question_name: '',
      buttonType:'',
      status: true,
      category:[],
      explanation: '',
      options:[
        {id:0,status:true,option_name:''},
        {id:0,status:false,option_name:''},
        {id:0,status:false,option_name:''},
        {id:0,status:false,option_name:''},
      ]
    }
   }
   
  
  const handleOptionChange = (index,keyName,value) => {
    setData((prevData) => {
      const updatedOptions = prevData.options.map((option, i) => {
        if (i === index) {
          return {...option,[keyName]:value};
        }
        return option;
      });
      return {
        ...prevData,
        options: updatedOptions,
      };
    });
  };
  
  function hendleForm(e){
    e.preventDefault();
    if(form_type == 'edit' && question && question.id){
      put(route('question.update',question.id));
    }else{
      post(route('question.store'),{
          onSuccess: () => {
              reset();
          }
      });
    }
    
  }
  
  
  const handleSelectChange = (selectedValues) => {
    setData('category',selectedValues);
  };
  function handleRadioButton(index,value){
     setData((prevData) => {
       const updateOption = prevData.options.map((option,i) => {
          if(index === i ){
            return {...option,'status' : true};
          }else{
            return {...option,'status' : false};
          }
       })
       return {
         ...prevData,
         options:updateOption
       }
     });
  }
  

  return (
    <AuthenticatedLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>}
      >
      <Head title="Questions" />
      <div className="py-12">
        <h3>Question {form_type}</h3>
        <form onSubmit={hendleForm}>
        
          <div className="form-group">
            <lable>Question</lable>
            <input type="text" className="form-control" name="question_name"
            value={data.question_name} 
            onChange={(e) => setData('question_name',e.target.value)}
            />
            <InputError message={errors.question_name} className="mt-2" />
          </div>
          
          <div className="row">
          {
            data.options ?
                  data.options.map((option,index) =>
                    <div className="col-sm-6" key={index}>
                        <div className="form-group">
                            <lable>Options {optionTag[index]}</lable>
                            <div className="d-flex">
                              <input type="text" className="form-control"
                              value={option.option_name}
                              onChange={(e) => handleOptionChange(index,"option_name",e.target.value)}
                              />
                              <input 
                              type="radio"
                              checked={option.status}
                              onChange={(e) => handleRadioButton(index,e.target.value)}
                              name="status" value="1"/>
                            </div>
                            
                            <InputError message={errors[`options.${index}.option_name`]} className="mt-2" />
                        </div>
                    </div>
                  )
                  : ''
          }
            
          </div>
  
          <div className="form-group">
            <lable>Explanation</lable>
            <textarea 
            name="explanation"
            className="form-control"
            onChange={(e) => setData('explanation',e.target.value) }>{data.explanation}</textarea>
            <InputError message={errors.explanation} className="mt-2" />
          </div>
          
          <div className="form-group">
            <lable>Categories</lable>
            <Select
              options={selectBoxKeyUpdate(categories)}
              isMulti
              value={selectBoxKeyUpdate(data.category)}
              onChange={handleSelectChange}
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
               <button type="submit" onClick={() => setButtonType('back') }  className="btn btn-info text-capitalize">{form_type}</button>
             
           </div>
           <Toster flash={flash} />
        </form>
      
      </div>
    </AuthenticatedLayout>
  );
}

export default QuestionCreate;