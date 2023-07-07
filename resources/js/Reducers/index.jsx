import { combineReducers } from 'redux';
import AuthReducer from './AuthReducer';
import changeState from './changeState';

const rootReducer = combineReducers({
  user: AuthReducer,
  sidebarShow:changeState,
});

export default rootReducer;
