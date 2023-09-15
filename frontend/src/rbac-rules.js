import { goods, flights} from "./rbac-consts";

const rules = {
  ROLE_ADMIN: {
    static: [
      goods.ADMIN
    ],
    dynamic: {}
  },
  ROLE_USER: {
    static: [
      goods.USER,
      flights.USER
    ],
    dynamic: {}
  },
  ROLE_OWNER: {
    static: [
      flights.OWNER,
      goods.OWNER
    ],
    dynamic: {}
  },
  ROLE_MANAGER: {
    static: [
      flights.MANAGER,
      goods.MANAGER
    ],
    dynamic: {}
  }
};

export default rules;
