import axios from 'axios'
class useAuth{
    private static token = localStorage.getItem('token')
    private static api = axios.create({
    baseURL: 'http://localhost:8000', // Defina a URL base do seu backend
    headers: {
      'Content-Type': 'application/json',
      Authorization: useAuth.token ? `Bearer ${useAuth.token}` : '',
    },

    });
    public static async axiosWithAuth (endpoint, options = {}){
      try {
        const response = await this.api({
          url: endpoint,
          method: options.method || 'GET',
          data: options.data || null,
          headers: headers.data || null,
        });
        return response.data;
      } catch (error) {
        throw error.response ? error.response.data.message : 'Erro na requisição';
      }
    }
    public static async login(form){
      try {
        const response = await axios.post('http://localhost:8000/login', form);
        const { token } = response.data;
        localStorage.setItem('token', token);
        this.api.defaults.headers.Authorization = `Bearer ${token}`;
        return response.data;
      } catch (error) {
        throw error.response ? error.response.data.message : error;
      }
    }
    public static async logout(){
      localStorage.removeItem('token');
      delete api.defaults.headers.Authorization;
    }

}

export default useAuth
