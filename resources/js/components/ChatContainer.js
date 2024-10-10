import React, { Component } from 'react';

import { connect } from "react-redux";
import { setMessage} from "../actions/messageActions.js";
import { sendMessage, connectToServer, disConnectToServer} from "../actions/websocketActions.js";



class ChatContainer extends Component{
    constructor(props) {
        super(props);
        this.state = {

        }
        this.localHost = ''
        this.sendMessageToClient = this.sendMessageToClient.bind(this);

        this.userInputMessage = this.userInputMessage.bind(this);
        this.changeMessage = this.changeMessage.bind(this);

    }
  
    componentDidMount() {
      this.props.onConnect();
    
    }

    componentWillUnmount() {
      this.props.onDisConnect()

    }
  
    sendMessageToClient(){

        this.props.onSendMessage(this.props.message, 1)
    }

    changeMessage(e){
        const value=(e.target.value)
                        ?e.target.value
                        :"";
        console.log("value = ", value)  
        this.props.onSetMessage(value);
    }
    userInputMessage(){
      if(true){
          let message =this.props.message;
          return (        <div>
                              <div className="mt-3"> 
                                  Сообщение:
                              </div>
                              <input  type="text" 
                                      style={{color:"black"}}
                                      name="message" 
                                      className="form-control input-sm" 
                                      placeholder="..."
                                      onChange={(e)=>this.changeMessage(e)} 
                                      value={message } />

                              <span className="input-group-btn">
                                  <button className="btn btn-primary btn-sm"  
                                          onClick={this.sendMessageToClient}>
                                      Отправить
                                  </button>
                              </span>
                          </div>
          
          )
      }


  }
    render() {

        return (
          <div>
             {this.userInputMessage()}
             <div className="border border-dark" style={{color:"black"}}>
                {
                  this.props.listMessage.map((msg,index)=>{
                      return( 
                          <div className="d-flex flex-row " key={index}>
                              <div className={`d-flex mt-1 mb-1 `} >
                                  {msg.body}
                              </div> 
                          
                          </div>
                      )
                  })
                }
            </div>

           
          </div>
        );
    }
}

const mapStateToProps = (state, ownProps) => ({
  message: messageSt(state),
  listMessage: state.listMessage,

});
const messageSt = state => {
  console.log(" state  = ", state)
  return state.message;
}
const mapActionsToProps = {

  onSetMessage: setMessage,
  onSendMessage: sendMessage,
  onConnect: connectToServer,
  onDisConnect: disConnectToServer,

};
export default connect(mapStateToProps, mapActionsToProps)(ChatContainer);

