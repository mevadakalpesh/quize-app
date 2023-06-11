import {
  useState,
  Suspense
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

export default function Authenticated( {
  user, header, children
}) {


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