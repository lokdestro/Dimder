import {SET_MESSAGE} from '../actions/constants.js';

export default function messageReducer(state = '', action) {
    switch (action.type) {
        case SET_MESSAGE:
            return setMessage(state, action.payload);
        default:
            return state;
    }
}
function setMessage (state, payload){
    let message = (payload === null)
                    ? ""
                    : payload
    return message
}
