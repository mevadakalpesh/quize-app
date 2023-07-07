import {
  useState,
  Suspense,
  useEffect
} from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import Dropdown from '@/Components/Dropdown';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import {
  Link
} from '@inertiajs/react';
import {
  AppSidebar,
  AppHeader,
  AppFooter
} from '@/Components/index'

import {
  CDropdown,
  CDropdownToggle,
  CDropdownMenu,
  CDropdownItem,
  CContainer, CSpinner 
} from '@coreui/react'
import { useDispatch } from 'react-redux';
import {authSet} from '@/Actions/AuthAction.jsx';
function Authenticated( {user, header, children}) {
const dispatch = useDispatch();

useEffect(() => {
  dispatch(authSet(user));
},[]);

  return (
    <div>
      <AppSidebar />
      <div className="wrapper d-flex flex-column min-vh-100 bg-light">
        <AppHeader />
        <div className="body flex-grow-1 px-3">
          <CContainer lg>
            <Suspense fallback={<CSpinner color="primary" />}>
                {children}
            </Suspense>
          </CContainer>
        </div>
        <AppFooter />
       
    </div>
    </div>
  );
}

export default  Authenticated;