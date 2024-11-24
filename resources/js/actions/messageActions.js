import { SET_MESSAGE, ADD_MESSAGE } from './constants.js';


export const setMessage = (message) => (dispatch, getState) =>{
    dispatch({
        type: SET_MESSAGE,
        payload: {message : message, id : "2"}
    });
}

export const addMessage = (message) => (dispatch, getState) =>{
    dispatch({
        type: ADD_MESSAGE,
        payload: message
    });
}


