import { combineReducers } from 'redux';

import messageReducer from './messageReducer.js';
import listMessageReducer from './listMessageReducer.js';



const combinedReducer = combineReducers({

    message: messageReducer,
    listMessage: listMessageReducer,

});


export default function rootReducer(state, action) {
  const intermediateState = combinedReducer(state, action)
  const finalState = crossSliceReducer(intermediateState, action)
  return finalState
}
function crossSliceReducer(state, action) {
 // console.log(action.type,"********** state.button=",state.button);
  // switch (action.type) {

  //   case FETCH_CONNECT_ROOM_ALIENT:

  //   default:
  //     return state
  // }
  return state;
}
