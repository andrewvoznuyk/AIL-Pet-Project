import SubColumnRow from "./SubColumnRow";
import React from "react";
import aircraftSettings from "./aircraftSettings";

/**
 * Represents full row in plane, and consists of several sub-rows parted by walkable ways
 * @param row
 * @param onButtonClick
 * @returns {Element}
 * @constructor
 */
function SeatsRow ({ row, onButtonClick, placeClass }) {

  return <>
    {row && row.map((subrow) => {

      return (
        <span style={{ padding: aircraftSettings.walkwayWidth }}>
          <SubColumnRow subrow={subrow} onButtonClick={onButtonClick} placeClass={placeClass}/>
        </span>
      );
    })}
  </>;
}

export default SeatsRow;