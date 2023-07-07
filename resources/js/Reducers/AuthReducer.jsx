import {
  AUTH_SET,
  AUTH_REMOVE
} from '@/Actions/AuthAction.jsx';

const initialState = {
  user: null
}

const AuthReducer = (state = initialState, action) => {
  switch (action.type) {
    case 'AUTH_SET':
      return {
        ...state,
        user: action.payload
      };
      break;
    case 'AUTH_REMOVE':
      return {
        ...state,
        user: null
      };
      break;
    default:
      return state;
    }
  }


  export default AuthReducer;