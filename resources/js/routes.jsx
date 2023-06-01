import React from 'react'

const Dashboard = React.lazy(() => import('./Pages/Dashboard'))

const routes = [
  { path: '/', exact: true, name: 'Home' },
  { path: '/dashboard', name: 'Dashboard', element: Dashboard },
  { path: route('login'), name: 'Login' },
]

export default routes
