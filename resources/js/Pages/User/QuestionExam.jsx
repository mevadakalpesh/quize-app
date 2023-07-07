import GuestLayout from '@/Layouts/GuestLayout';
import {Head,useForm} from '@inertiajs/react';
import { useState,useEffect } from 'react'
import Question from '@/Pages/User/Question';

function UserQuestionList( { auth,quizes ,quizeHistories}) {
  
  return (
    <GuestLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800
      leading-tight">Questions</h2>}
      >
      <Head title="Quize Details" />
      <div className="py-12">
        <h3>Questions </h3>
        <h5>{quizes.quize_name}</h5>
        { quizes && quizes.questions && quizes.questions.length > 0  ?
          
          quizes.questions.map((question)=>
              <Question question={question} quize={quizes} quizeHistory={quizeHistories} />
          )
            :
          'No Question'
        }
          
      </div>
    </GuestLayout>
  );
}

export default UserQuestionList;