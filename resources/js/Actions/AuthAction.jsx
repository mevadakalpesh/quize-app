// Actions Type
export const AUTH_SET = 'AUTH_SET';
export const AUTH_REMOVE = 'AUTH_REMOVE';

export const authSet = (user) => {
  return {type:AUTH_SET,payload: user};
}

export const authRemove = () => {
  return {type:AUTH_REMOVE};
}

