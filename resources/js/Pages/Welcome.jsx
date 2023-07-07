import { Link, Head } from '@inertiajs/react';

export default function Welcome({ auth, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Welcome" />
            <div className="container">
                <div className="d-flex justify-content-end">
                    {auth.user  ? 
                    (
                      
                        auth.user.is_admin == 1 ?
                        <Link href={route('dashboard')} className="text-decoration-none">
                            Dashboard
                        </Link>
                        :
                        <Link href={route('UserQuizeList')} className="text-decoration-none">
                            View Quize
                        </Link>
                      
                        
                    ) : (
                        <>
                            <Link href={route('login')}
                            className="text-decoration-none mx-4 my-2">
                                Log in
                            </Link>

                            <Link href={route('register')}
                            className="text-decoration-none mx-2 my-2 " >
                                Register
                            </Link>
                        </>
                    )}
                </div>
                
               <div className="center-box " >
                    
                    <h1>Quize App</h1>
                    
               </div>
          
            </div>
        </>
    );
}
