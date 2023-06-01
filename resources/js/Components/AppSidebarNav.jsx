import React from 'react'
import { Link } from '@inertiajs/react';
import PropTypes from 'prop-types'

import { CBadge } from '@coreui/react'

export const AppSidebarNav = ({ items }) => {
  
  const navLink = (name, icon, badge,path) => {
    return (
      <>
        {icon && icon}
        {name && 
          <Link href={path}>{name}</Link>
        }
        {badge && (
          <CBadge color={badge.color} className="ms-auto">
            {badge.text}
          </CBadge>
        )}
      </>
    )
  }

  const navItem = (item, index) => {
    const { component, name, badge, icon, ...rest } = item
    const Component = component
    return (
      <Component
        {...(rest.to && !rest.items)}
        key={index}
        {...rest}
      >
        {navLink(name, icon, badge,rest.to)}
      </Component>
    )
  }
  const navGroup = (item, index) => {
    const { component, name, icon, to, ...rest } = item
    const Component = component
    return (
      <Component
        idx={String(index)}
        key={index}
        toggler={navLink(name, icon)}
        {...rest}
      >
        {item.items?.map((item, index) =>
          item.items ? navGroup(item, index) : navItem(item, index),
        )}
      </Component>
    )
  }

  return (
    <React.Fragment>
      {items &&
        items.map((item, index) => (item.items ? navGroup(item, index) : navItem(item, index)))}
    </React.Fragment>
  )
}

AppSidebarNav.propTypes = {
  items: PropTypes.arrayOf(PropTypes.any).isRequired,
}
