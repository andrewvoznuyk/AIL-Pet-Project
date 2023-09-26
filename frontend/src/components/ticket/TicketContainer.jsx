import { useState } from "react";

const TicketContainer = () => {
  const {flightId, setFlightId} = useState("");
  const {name, setName} = useState("");
  const {Surname, setSurname} = useState("");
  const {classType, setClassType} = useState("");
  const {place, setPlace} = useState("");
  const {luggageMass, setLuggageMass} = useState("");



  return <>
  <p>My ticket</p>
  </>
}

export default TicketContainer;