<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\State;
use Illuminate\Database\Seeder;

class IndiaStatesCitiesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Andhra Pradesh' => ['Visakhapatnam', 'Vijayawada', 'Guntur', 'Nellore', 'Kurnool', 'Rajahmundry', 'Tirupati', 'Kakinada', 'Anantapur', 'Kadapa', 'Eluru', 'Ongole'],
            'Arunachal Pradesh' => ['Itanagar', 'Naharlagun', 'Pasighat', 'Tawang', 'Ziro', 'Bomdila', 'Tezu'],
            'Assam' => ['Guwahati', 'Silchar', 'Dibrugarh', 'Jorhat', 'Nagaon', 'Tinsukia', 'Tezpur', 'Bongaigaon', 'Dhubri', 'Diphu'],
            'Bihar' => ['Patna', 'Gaya', 'Bhagalpur', 'Muzaffarpur', 'Darbhanga', 'Purnia', 'Arrah', 'Begusarai', 'Katihar', 'Munger', 'Chhapra', 'Bettiah', 'Sasaram', 'Hajipur'],
            'Chhattisgarh' => ['Raipur', 'Bhilai', 'Bilaspur', 'Korba', 'Durg', 'Rajnandgaon', 'Raigarh', 'Jagdalpur', 'Ambikapur'],
            'Goa' => ['Panaji', 'Margao', 'Vasco da Gama', 'Mapusa', 'Ponda', 'Bicholim'],
            'Gujarat' => ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Junagadh', 'Gandhinagar', 'Anand', 'Nadiad', 'Morbi', 'Mehsana', 'Bharuch', 'Navsari', 'Vapi', 'Porbandar', 'Bhuj', 'Gandhidham'],
            'Haryana' => ['Faridabad', 'Gurugram', 'Panipat', 'Ambala', 'Yamunanagar', 'Rohtak', 'Hisar', 'Karnal', 'Sonipat', 'Panchkula', 'Bhiwani', 'Sirsa', 'Bahadurgarh', 'Jind', 'Kurukshetra', 'Rewari'],
            'Himachal Pradesh' => ['Shimla', 'Dharamshala', 'Solan', 'Mandi', 'Kullu', 'Manali', 'Bilaspur', 'Hamirpur', 'Una', 'Chamba', 'Palampur'],
            'Jharkhand' => ['Ranchi', 'Jamshedpur', 'Dhanbad', 'Bokaro Steel City', 'Deoghar', 'Hazaribagh', 'Giridih', 'Ramgarh', 'Medininagar', 'Chaibasa'],
            'Karnataka' => ['Bengaluru', 'Mysuru', 'Hubballi', 'Mangaluru', 'Belagavi', 'Kalaburagi', 'Davanagere', 'Ballari', 'Vijayapura', 'Shivamogga', 'Tumakuru', 'Udupi', 'Raichur', 'Hassan', 'Bidar', 'Mandya'],
            'Kerala' => ['Thiruvananthapuram', 'Kochi', 'Kozhikode', 'Thrissur', 'Kollam', 'Alappuzha', 'Palakkad', 'Kannur', 'Kottayam', 'Malappuram', 'Kasaragod', 'Pathanamthitta'],
            'Madhya Pradesh' => ['Indore', 'Bhopal', 'Jabalpur', 'Gwalior', 'Ujjain', 'Sagar', 'Dewas', 'Satna', 'Ratlam', 'Rewa', 'Katni', 'Singrauli', 'Burhanpur', 'Khandwa', 'Chhindwara', 'Morena'],
            'Maharashtra' => ['Mumbai', 'Pune', 'Nagpur', 'Nashik', 'Thane', 'Aurangabad', 'Solapur', 'Kolhapur', 'Amravati', 'Navi Mumbai', 'Sangli', 'Jalgaon', 'Akola', 'Latur', 'Dhule', 'Ahmednagar', 'Nanded', 'Chandrapur', 'Satara', 'Ratnagiri', 'Pimpri-Chinchwad', 'Kalyan', 'Vasai-Virar', 'Mira-Bhayandar'],
            'Manipur' => ['Imphal', 'Thoubal', 'Bishnupur', 'Churachandpur', 'Kakching', 'Ukhrul'],
            'Meghalaya' => ['Shillong', 'Tura', 'Jowai', 'Nongstoin', 'Baghmara'],
            'Mizoram' => ['Aizawl', 'Lunglei', 'Champhai', 'Serchhip', 'Kolasib'],
            'Nagaland' => ['Kohima', 'Dimapur', 'Mokokchung', 'Tuensang', 'Wokha', 'Zunheboto'],
            'Odisha' => ['Bhubaneswar', 'Cuttack', 'Rourkela', 'Berhampur', 'Sambalpur', 'Puri', 'Balasore', 'Bhadrak', 'Baripada', 'Jharsuguda', 'Jeypore'],
            'Punjab' => ['Ludhiana', 'Amritsar', 'Jalandhar', 'Patiala', 'Bathinda', 'Mohali', 'Pathankot', 'Hoshiarpur', 'Batala', 'Moga', 'Abohar', 'Malerkotla', 'Khanna', 'Phagwara', 'Muktsar', 'Barnala', 'Firozpur', 'Kapurthala', 'Rupnagar', 'Sangrur', 'Kharar'],
            'Rajasthan' => ['Jaipur', 'Jodhpur', 'Kota', 'Bikaner', 'Ajmer', 'Udaipur', 'Bhilwara', 'Alwar', 'Bharatpur', 'Sikar', 'Pali', 'Sri Ganganagar', 'Tonk', 'Kishangarh', 'Beawar', 'Hanumangarh', 'Chittorgarh', 'Jaisalmer', 'Barmer'],
            'Sikkim' => ['Gangtok', 'Namchi', 'Gyalshing', 'Mangan', 'Pelling'],
            'Tamil Nadu' => ['Chennai', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli', 'Tiruppur', 'Erode', 'Vellore', 'Thoothukudi', 'Dindigul', 'Thanjavur', 'Hosur', 'Nagercoil', 'Kanchipuram', 'Karur', 'Cuddalore', 'Kumbakonam'],
            'Telangana' => ['Hyderabad', 'Warangal', 'Nizamabad', 'Karimnagar', 'Khammam', 'Ramagundam', 'Mahbubnagar', 'Nalgonda', 'Adilabad', 'Siddipet', 'Secunderabad'],
            'Tripura' => ['Agartala', 'Udaipur', 'Dharmanagar', 'Kailasahar', 'Belonia', 'Ambassa'],
            'Uttar Pradesh' => ['Lucknow', 'Kanpur', 'Ghaziabad', 'Agra', 'Varanasi', 'Meerut', 'Prayagraj', 'Bareilly', 'Aligarh', 'Moradabad', 'Saharanpur', 'Gorakhpur', 'Noida', 'Greater Noida', 'Firozabad', 'Jhansi', 'Muzaffarnagar', 'Mathura', 'Rampur', 'Shahjahanpur', 'Ayodhya', 'Mirzapur', 'Etawah', 'Sitapur', 'Bulandshahr', 'Hapur', 'Raebareli', 'Unnao', 'Lakhimpur'],
            'Uttarakhand' => ['Dehradun', 'Haridwar', 'Roorkee', 'Haldwani', 'Rudrapur', 'Kashipur', 'Rishikesh', 'Nainital', 'Mussoorie', 'Almora', 'Pithoragarh'],
            'West Bengal' => ['Kolkata', 'Howrah', 'Durgapur', 'Asansol', 'Siliguri', 'Bardhaman', 'Malda', 'Baharampur', 'Habra', 'Kharagpur', 'Haldia', 'Raiganj', 'Darjeeling', 'Jalpaiguri', 'Cooch Behar', 'Bankura', 'Purulia'],

            // Union Territories
            'Andaman and Nicobar Islands' => ['Port Blair', 'Diglipur', 'Mayabunder', 'Rangat'],
            'Chandigarh' => ['Chandigarh'],
            'Dadra and Nagar Haveli and Daman and Diu' => ['Daman', 'Diu', 'Silvassa'],
            'Delhi' => ['New Delhi', 'Delhi', 'Dwarka', 'Rohini', 'Saket', 'Karol Bagh', 'Lajpat Nagar', 'Janakpuri', 'Pitampura', 'Laxmi Nagar'],
            'Jammu and Kashmir' => ['Srinagar', 'Jammu', 'Anantnag', 'Baramulla', 'Sopore', 'Kathua', 'Udhampur', 'Pulwama', 'Kupwara'],
            'Ladakh' => ['Leh', 'Kargil'],
            'Lakshadweep' => ['Kavaratti', 'Agatti', 'Minicoy', 'Amini'],
            'Puducherry' => ['Puducherry', 'Karaikal', 'Mahe', 'Yanam'],
        ];

        foreach ($data as $stateName => $cities) {
            $state = State::firstOrCreate(['name' => $stateName]);

            foreach (array_unique($cities) as $cityName) {
                City::firstOrCreate([
                    'state_id' => $state->id,
                    'name'     => $cityName,
                ]);
            }
        }
    }
}