import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import {
  useState
} from 'react';

export default function Guest({ children }) {
  const [menuSatatus,setMenuSataus] = useState(false);
    return (
        <div className="container">
        <nav className="navbar navbar-expand-lg bg-body-tertiary">
          <div className="container-fluid">
            <a className="navbar-brand" href="#">Quize App</a>
            <button className="navbar-toggler" type="button"
            onClick={() => setMenuSataus(!menuSatatus)}>
              <span className="navbar-toggler-icon"></span>
            </button>
            {
              menuSatatus ? 
            <div className=" navbar-collapse" >
              <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                <Link href={route('home')}>Home</Link>
                <Link href={route('logout')} method="POST">Logout</Link>
            
              </ul>
            </div>
            :''
            }
          </div>
        </nav>
            <div className="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {children}
            </div>
        </div>
    );
}
