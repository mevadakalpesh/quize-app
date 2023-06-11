import React from 'react'
import CIcon from '@coreui/icons-react'
import {
  cilBell,
  cilCalculator,
  cilChartPie,
  cilCursor,
  cilDescription,
  cilDrop,
  cilNotes,
  cilPencil,
  cilPuzzle,
  cilSpeedometer,
  cilStar,
} from '@coreui/icons'
import {
  CNavGroup,
  CNavItem,
  CNavTitle
} from '@coreui/react'

const _nav = [
  {
  component: CNavItem,
  name: 'Dashboard',
  to: route('dashboard'),
  icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
  badge: {
    color: 'info',
    text: 'NEW',
  },
},
  {
    component: CNavItem,
    name: 'Question',
    to: route('question.index'),
    icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
  },
  {
    component: CNavItem,
    name: 'Quize',
    to: route('quize.create'),
    icon: <CIcon icon={cilSpeedometer} customClassName="nav-icon" />,
  },

  /*
  {
    component: CNavGroup,
    name: 'Question',
    to: route('question.index'),
    icon: <CIcon icon={cilPuzzle} customClassName="nav-icon" />,
    items: [
      {
        component: CNavItem,
        name: 'Accordion',
        to: route('profile.edit'),
      },
    ],
  },
  */
]

export default _nav