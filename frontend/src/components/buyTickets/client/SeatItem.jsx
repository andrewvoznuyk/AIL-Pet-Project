import { Button } from "@mui/material";
import { useState } from "react";
import aircraftSettings from "./aircraftSettings";

function SeatItem ({number, placeClass, onButtonClick, isPlaceSold}) {

  const [isClicked, setIsClicked] = useState(false);

  const onItemClick = () => {
    setIsClicked(!isClicked);
    let data = {place: number, class: placeClass};
    onButtonClick(data);
  }

  const getColor = () => {
    return aircraftSettings.placeClasses[placeClass].color;
  }

  return <>
    <Button
      variant={isClicked ? "contained" : "outlined"}
      onClick={onItemClick}
      color={getColor()}
      disabled={isPlaceSold(number)}
    >
      {number}
    </Button>

  </>
}

export default SeatItem;