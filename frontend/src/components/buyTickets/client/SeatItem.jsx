import { Button } from "@mui/material";
import { useState } from "react";
import aircraftSettings from "./aircraftSettings";

function SeatItem ({number, placeClass, onButtonClick}) {

  const [isClicked, setIsClicked] = useState(false);

  const onItemClick = () => {
    setIsClicked(!isClicked);
    onButtonClick({id: number, placeClass: placeClass});
  }

  const getColor = () => {
    return aircraftSettings.placeClasses[placeClass].color;
  }

  return <>
    <Button
      variant={isClicked ? "contained" : "outlined"}
      onClick={onItemClick}
      color={getColor()}
    >
      {number}
    </Button>

  </>
}

export default SeatItem;