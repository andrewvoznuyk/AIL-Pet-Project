import {useContext} from "react";
import {AppContext} from "../../App";
import {default as OwnerCabinetContainer} from "../../components/cabinet/owner/CabinetContainer";
import {default as ManagerCabinetContainer} from "../../components/cabinet/owner/CabinetContainer";
import { flights } from "../../rbac-consts";
import Can from "../../components/elemets/can/Can";
import NotFoundPage from "../notFound/NotFoundPage";

const CabinetPage = () => {
  const { user } = useContext(AppContext);

  if(!user){
    return <NotFoundPage />
  }

    return (
        <>
          <Can
            role={user.roles}
            perform={flights.OWNER}
            yes={() => <OwnerCabinetContainer />}
          />
          <Can
            role={user.roles}
            perform={flights.MANAGER}
            yes={() => <ManagerCabinetContainer />}
          />
        </>
    );
};

export default CabinetPage;