import GuestLayout from '@/Layouts/GuestLayout';
import {Head,useForm} from '@inertiajs/react';
import { useState,useEffect } from 'react'


function UserQuestionList( { auth,quizes }) {
  
  return (
    <GuestLayout
      user={auth.user}
      header={<h2 className="font-semibold text-xl text-gray-800
      leading-tight">Questions</h2>}
      >
      <Head title="Quize Details" />
      <div className="py-12">
        <h3>Your quize time is over </h3>
      </div>
    </GuestLayout>
  );
}

export default UserQuestionList;