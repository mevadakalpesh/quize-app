import QuizsDetails from '@/Pages/User/QuizsDetails';
import GuestLayout from '@/Layouts/GuestLayout';
import {Head,useForm} from '@inertiajs/react';
import { useState,useEffect } from 'react'


function UserQuestionList( { auth,quizes }) {
  
  return (
    <GuestLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800
      leading-tight">Quize</h2>}
      >
      <Head title="Quize Details" />
      <div className="py-12">
        <h3>Quize Details </h3>
        {
          quizes && quizes.length > 0 ?
            quizes.map((quize,index) => 
              <QuizsDetails key={index} quize={quize} />
            )
          : "No Quize"
        }
      </div>
    </GuestLayout>
  );
}

export default UserQuestionList;