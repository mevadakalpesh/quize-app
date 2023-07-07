import { useEffect } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, router,useForm } from '@inertiajs/react';
import {
  CButton,
  CCard,
  CCardBody,
  CCardGroup,
  CCol,
  CContainer,
  CForm,
  CFormInput,
  CInputGroup,
  CInputGroupText,
  CRow,
} from '@coreui/react'
import Toster from '@/Components/Toster';
import CIcon from '@coreui/icons-react'
import { cilLockLocked, cilUser } from '@coreui/icons'

export default function Login({ status, canResetPassword ,flash}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        post(route('login'));
    };
    

    return (
      
          <div className="bg-light min-vh-100 d-flex flex-row align-items-center">
      <CContainer>
        <CRow className="justify-content-center">
          <CCol md={8}>
            <CCardGroup>
              <CCard className="p-4">
                <CCardBody>
                   <form onSubmit={submit}>
                    <h1>Login</h1>
                    <p className="text-medium-emphasis">Sign In to your account</p>
                    <CInputGroup className="mb-3">
                      <CInputGroupText>
                        <CIcon icon={cilUser} />
                      </CInputGroupText>
                      
                      <CFormInput 
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                      />
                    </CInputGroup>
                      <InputError message={errors.email} className="mt-2
                      text-danger" />
                    <CInputGroup className="mb-4">
                      <CInputGroupText>
                        <CIcon icon={cilLockLocked} />
                      </CInputGroupText>
                      
                      <CFormInput
                        type="password"
                        placeholder="Password"
                        autoComplete="current-password"
                        id="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        onChange={(e) => setData('password', e.target.value)}
                      />
                      <InputError message={errors.password} className="mt-2 text-danger" />
                    </CInputGroup>
                    <CRow>
                      <CCol xs={6}>
                        <CButton type="submit" color="primary" className="px-4" disabled={processing}>
                          Login
                        </CButton>
                      </CCol>
                     
                    </CRow>
                    <div className="mt-3 ">
                        <Link
                            href={route('password.request')}
                            className="text-decoration-none"
                        >
                            Forgot your password?
                        </Link>
                        <br />
                         <Link
                            href={route('register')}
                            className="text-decoration-none"
                        >
                            Register Now
                        </Link>
                    </div>
                  </form>
                </CCardBody>
              </CCard>
             <div className="d-grid gap-2 col-6 mx-auto">
               <a href={route('socialLogin','google')} className="btn bg-white">Login with Google </a>
               <a href={route('socialLogin','github')} className="btn bg-black text-white">Login with Github</a>
            </div>
              
            </CCardGroup>
          </CCol>
        </CRow>
      </CContainer>
         <Toster flash={flash} />
    </div>
    
    );
}
