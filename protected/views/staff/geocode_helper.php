<?php

class GeocodeHelper {
    
    // Performance tracking
    private static $performance_log = array();
    private static $performance_start = null;
    
    private static function logPerformance($message) {
        // Log fonksiyonu devre dışı - performans için kaldırıldı
    }
    
    public static function getPerformanceLog() {
        return self::$performance_log;
    }
    
    private static $proxies = [
        'p.webshare.io:80:yxbrrskz-1:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-2:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-3:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-4:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-5:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-6:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-7:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-8:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-9:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-10:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-11:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-12:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-13:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-14:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-15:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-16:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-17:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-18:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-19:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-20:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-21:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-22:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-23:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-24:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-25:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-26:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-27:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-28:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-29:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-30:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-31:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-32:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-33:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-34:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-35:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-36:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-37:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-38:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-39:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-40:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-41:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-42:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-43:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-44:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-45:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-46:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-47:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-48:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-49:snlhfqplztltw',
        'p.webshare.io:80:yxbrrskz-50:snlhfqplztltw'
    ];
    
    private static $proxy_index = 0;
    
    /**
     * ANA FONKSİYON: Benzersiz client adreslerini geocode eder
     * @param array $clients_data - clientname ve address içeren array
     * @return array - geocode sonuçları
     */
    public static function geocodeUniqueClients($clients_data) {
        // Cache yenileme işlemini kaldırdık - performans için
        
        // 1. ADIM: Benzersiz clientname'leri filtrele
        $unique_clients = self::filterUniqueClients($clients_data);
        
        // 2. ADIM: Geçerli adresleri filtrele
        $valid_clients = self::filterValidAddresses($unique_clients);
        
        // 3. ADIM: Cache'den kontrol et
        if (empty($valid_clients)) {
            return array();
        }
        
        $cache_results = self::checkCache($valid_clients);
        
        // 4. ADIM: Cache'de olmayan adresleri geocode et
        $geocode_results = array();
        if (!empty($cache_results['missing_clients'])) {
            $geocode_results = self::performGeocoding($cache_results['missing_clients']);
            
            // Yeni sonuçları cache'e kaydet
            self::saveToCache($cache_results['missing_clients'], $geocode_results);
        }
        
        // 5. ADIM: Cache ve yeni sonuçları birleştir
        $combined_results = self::combineResults($cache_results, $geocode_results);
        
        // 6. ADIM: Sonuçları client'larla eşleştir
        $final_results = self::mapResultsToClients($unique_clients, $combined_results);
        
        return $final_results;
    }
    
    /**
     * Benzersiz clientname'leri filtreler
     */
    private static function filterUniqueClients($clients_data) {
        $unique_clients = array();
        $seen_clients = array();
        
        foreach ($clients_data as $client) {
            $clientname = trim($client['clientname'] ?? '');
            $address = trim($client['address'] ?? '');
            
            if (empty($clientname)) {
                continue;
            }
            
            $client_key = strtolower($clientname);
            
            if (!isset($seen_clients[$client_key])) {
                $unique_clients[] = array(
                    'clientname' => $clientname,
                    'address' => $address,
                    'original_index' => count($unique_clients)
                );
                $seen_clients[$client_key] = true;
            }
        }
        
        return $unique_clients;
    }
    
    /**
     * Geçerli adresleri filtreler
     */
    private static function filterValidAddresses($unique_clients) {
     
        $valid_clients = array();
        
        foreach ($unique_clients as $client) {
            $address = trim($client['address']);
            
            if (empty($address) || strlen($address) < 3) {
                continue;
            }
            
            $valid_clients[] = $client;
        }
        
        return $valid_clients;
    }
    
    /**
     * Geocoding işlemini gerçekleştirir
     */
    private static function performGeocoding($missing_clients) {
        // Missing clients zaten doğru formatta, sadece index'leri düzelt
        $addresses_for_geocoding = array();
        $index_map = array(); // Orijinal index'leri takip et
        
        $new_index = 0;
        foreach ($missing_clients as $original_index => $client) {
            $addresses_for_geocoding[$new_index] = array('address' => $client['address']);
            $index_map[$new_index] = $original_index;
            $new_index++;
        }
        
        // Varsayılan geocoding sistemi kullan
        $raw_results = self::geocodeParallel($addresses_for_geocoding);
        
        // Sonuçları orijinal index'lerle eşleştir
        $mapped_results = array();
        foreach ($raw_results as $new_index => $result) {
            if (isset($index_map[$new_index])) {
                $original_index = $index_map[$new_index];
                $mapped_results[$original_index] = $result;
            }
        }
        
        return $mapped_results;
    }
    
    /**
     * Cache'den adresleri kontrol eder
     */
    private static function checkCache($valid_clients) {
        $cached_results = array();
        $missing_clients = array();
        $cached_count = 0;
        $missing_count = 0;
        
        // Hızlı cache kontrolü - tablo varlığını kontrol etme, direkt sorgu dene
        if (empty($valid_clients)) {
            return array(
                'cached_results' => $cached_results,
                'missing_clients' => $missing_clients,
                'cached_count' => $cached_count,
                'missing_count' => $missing_count
            );
        }
        
        // Tüm adreslerin hash'lerini hazırla
        $address_hashes = array();
        $address_map = array();
        
        foreach ($valid_clients as $index => $client) {
            $address = trim($client['address']);
            $address_hash = md5(strtolower($address));
            $address_hashes[] = $address_hash;
            $address_map[$address_hash] = array('index' => $index, 'client' => $client, 'address' => $address);
        }
        
        try {
            // Tek sorguda tüm cache kayıtlarını getir
            $placeholders = str_repeat('?,', count($address_hashes) - 1) . '?';
            $cache_query = "SELECT address_hash, lat, lon, found FROM geocode_cache WHERE address_hash IN ($placeholders)";
            $cache_results_db = Yii::app()->db->createCommand($cache_query)->queryAll(true, $address_hashes);
            
            // Cache sonuçlarını işle
            $found_hashes = array();
            foreach ($cache_results_db as $cache_result) {
                $hash = $cache_result['address_hash'];
                $found_hashes[] = $hash;
                
                if (isset($address_map[$hash])) {
                    $index = $address_map[$hash]['index'];
                    $address = $address_map[$hash]['address'];
                    
                    $lat_val = $cache_result['lat'] ? floatval($cache_result['lat']) : null;
                    $lon_val = $cache_result['lon'] ? floatval($cache_result['lon']) : null;
                    $found_val = (bool)$cache_result['found'];
                    
                    // Cache'de varsa direkt kullan - artık kontrol etme
                    $cached_results[$index] = array(
                        'address' => $address,
                        'lat' => $lat_val,
                        'lon' => $lon_val,
                        'found' => $found_val,
                        'proxy_used' => 'CACHED',
                        'response_info' => $found_val ? 'Cache hit - success' : 'Cache hit - failed'
                    );
                    $cached_count++;
                }
            }
            
            // Cache'de bulunmayan adresleri missing olarak işaretle
            foreach ($address_map as $hash => $data) {
                if (!in_array($hash, $found_hashes)) {
                    $missing_clients[$data['index']] = $data['client'];
                    $missing_count++;
                }
            }
            
        } catch (Exception $e) {
            // Cache sorgu hatası - tüm adresleri missing olarak işaretle
            foreach ($valid_clients as $index => $client) {
                $missing_clients[$index] = $client;
                $missing_count++;
            }
        }
        
        return array(
            'cached_results' => $cached_results,
            'missing_clients' => $missing_clients,
            'cached_count' => $cached_count,
            'missing_count' => $missing_count
        );
    }
    
    /**
     * Yeni sonuçları cache'e kaydeder (toplu insert)
     */
    private static function saveToCache($missing_clients, $geocode_results) {
        if (empty($geocode_results)) {
            return;
        }
        
        try {
            // Toplu insert için değerleri hazırla
            $values = array();
            $params = array();
            $param_index = 0;
            
            foreach ($missing_clients as $index => $client) {
                if (isset($geocode_results[$index])) {
                    $address = trim($client['address']);
                    $address_hash = md5(strtolower($address));
                    $result = $geocode_results[$index];
                    
                    $values[] = "(:address{$param_index}, :hash{$param_index}, :lat{$param_index}, :lon{$param_index}, :found{$param_index})";
                    
                    $params[":address{$param_index}"] = $address;
                    $params[":hash{$param_index}"] = $address_hash;
                    $params[":lat{$param_index}"] = $result['lat'];
                    $params[":lon{$param_index}"] = $result['lon'];
                    $params[":found{$param_index}"] = $result['found'] ? 1 : 0;
                    
                    $param_index++;
                }
            }
            
            if (!empty($values)) {
                $insert_query = "INSERT INTO geocode_cache (address, address_hash, lat, lon, found) VALUES " . 
                               implode(', ', $values) . 
                               " ON DUPLICATE KEY UPDATE lat = VALUES(lat), lon = VALUES(lon), found = VALUES(found), updated_at = NOW()";
                
                $insert_command = Yii::app()->db->createCommand($insert_query);
                foreach ($params as $param => $value) {
                    $insert_command->bindValue($param, $value);
                }
                
                $insert_command->execute();
            }
            
        } catch (Exception $e) {
            // Toplu insert başarısız olursa tek tek dene
            foreach ($missing_clients as $index => $client) {
                if (isset($geocode_results[$index])) {
                    $address = trim($client['address']);
                    $address_hash = md5(strtolower($address));
                    $result = $geocode_results[$index];
                    
                    try {
                        $single_insert = "INSERT INTO geocode_cache (address, address_hash, lat, lon, found) 
                                         VALUES (:address, :hash, :lat, :lon, :found) 
                                         ON DUPLICATE KEY UPDATE 
                                         lat = VALUES(lat), lon = VALUES(lon), found = VALUES(found), updated_at = NOW()";
                        
                        $single_command = Yii::app()->db->createCommand($single_insert);
                        $single_command->bindValue(':address', $address);
                        $single_command->bindValue(':hash', $address_hash);
                        $single_command->bindValue(':lat', $result['lat']);
                        $single_command->bindValue(':lon', $result['lon']);
                        $single_command->bindValue(':found', $result['found'] ? 1 : 0);
                        
                        $single_command->execute();
                    } catch (Exception $e2) {
                        // Tek kayıt da başarısız - devam et
                        continue;
                    }
                }
            }
        }
    }
    
    /**
     * Cache ve yeni sonuçları birleştirir
     */
    private static function combineResults($cache_results, $geocode_results) {
        $combined = $cache_results['cached_results'];
        
        // Yeni geocoding sonuçlarını ekle
        foreach ($geocode_results as $index => $result) {
            $combined[$index] = $result;
        }
        
        // Index sırasına göre sırala
        ksort($combined);
        
        return array_values($combined);
    }
    
    /**
     * Sonuçları client'larla eşleştirir
     */
    private static function mapResultsToClients($unique_clients, $geocode_results) {
        $final_results = array();
        
        for ($i = 0; $i < count($unique_clients); $i++) {
            $client = $unique_clients[$i];
            $result = isset($geocode_results[$i]) ? $geocode_results[$i] : null;
            
            $final_result = array(
                'clientname' => $client['clientname'],
                'address' => $client['address'],
                'lat' => $result ? $result['lat'] : null,
                'lon' => $result ? $result['lon'] : null,
                'found' => $result ? $result['found'] : false,
                'proxy_used' => $result ? $result['proxy_used'] : null,
                'response_info' => $result ? $result['response_info'] : 'Adres işlenmedi'
            );
            
            $final_results[] = $final_result;
        }
        
        return $final_results;
    }
    

    
    private static function testWithoutProxy() {
        $test_url = 'https://nominatim.openstreetmap.org/search?format=json&q=Istanbul+Turkey&limit=1';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $test_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        
        curl_close($ch);
        
        return ($response !== false && $http_code === 200);
    }
    
    private static function extractPostcode($address) {
        // Adresi kelimelere ayır
        $words = preg_split('/[\s,]+/', trim($address));
        $words = array_filter($words); // Boş elemanları temizle
        
        if (count($words) < 2) {
            return null;
        }
        
        // Son 2 kelimeyi al
        $last_two = array_slice($words, -2);
        $postcode = implode(' ', $last_two);
        
        // Posta kodu formatını kontrol et (UK posta kodu benzeri)
        if (preg_match('/[A-Z]{1,2}\d{1,2}\s?\d[A-Z]{2}/', $postcode)) {
            return $postcode;
        }
        
        // Eğer posta kodu formatında değilse, yine de son 2 kelimeyi dene
        return $postcode;
    }
    
    private static function testSpecificAddress($address) {
        // Proxy'siz test
        $url = 'https://nominatim.openstreetmap.org/search?format=json&q=' . urlencode($address) . '&limit=1';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        
        curl_close($ch);
        
        // Proxy'li test
        if (!empty(self::$proxies)) {
            $proxy = self::$proxies[0];
            $ch2 = self::createCurlHandle($address, $proxy);
            if ($ch2) {
                $response2 = curl_exec($ch2);
                $http_code2 = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
                $curl_error2 = curl_error($ch2);
                
                curl_close($ch2);
            }
        }
    }
    
    private static function testProxy($proxy_string) {
        $ch = self::createCurlHandle("Istanbul Turkey", $proxy_string);
        if (!$ch) {
            return false;
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        
        curl_close($ch);
        
        return ($response !== false && $http_code === 200);
    }
    
    private static function geocodeParallel($addresses) {
        // Optimize edilmiş paralel geocoding - önce posta kodu, sonra tam adres
        return self::geocodeParallelOptimized($addresses);
    }
    
    /**
     * Optimize edilmiş paralel geocoding - önce posta kodu, sonra tam adres
     */
    private static function geocodeParallelOptimized($addresses) {
        // 1. ADIM: Önce tüm adreslerin posta kodlarını paralel olarak dene
        $postcode_results = self::geocodePostcodesParallelOptimized($addresses);
        
        // 2. ADIM: Sadece posta kodu başarısız olanları tam adres ile dene
        $failed_addresses = array();
        $final_results = array();
        $postcode_success_count = 0;
        
        foreach ($addresses as $index => $addr) {
            if (isset($postcode_results[$index]) && $postcode_results[$index]['found']) {
                // Posta kodu başarılı - direkt kullan, tam adres işleme alma
                $final_results[$index] = $postcode_results[$index];
                $postcode_success_count++;
            } else {
                // Posta kodu başarısız - tam adres listesine ekle
                $failed_addresses[$index] = $addr;
            }
        }
        
        // Performans logu
        $total_addresses = count($addresses);
        $failed_count = count($failed_addresses);
        
        if ($postcode_success_count > 0) {
            $percentage = round(($postcode_success_count / $total_addresses) * 100, 1);
            self::logPerformance("🚀 PERFORMANS: $postcode_success_count/$total_addresses adres (%$percentage) posta kodu ile bulundu - tam adres işlemi atlandı!");
        }
        
        if ($failed_count > 0) {
            self::logPerformance("⚠️  $failed_count adres posta kodundan bulunamadı - tam adres ile denenecek");
        }
        
        // Tam adres ile paralel geocoding (sadece başarısız olanlar için)
        if (!empty($failed_addresses)) {
            $full_address_results = self::geocodeFullAddressesParallel($failed_addresses);
            
            // Sonuçları birleştir
            foreach ($full_address_results as $index => $result) {
                $final_results[$index] = $result;
            }
        }
        
        // Index sırasına göre sırala
        ksort($final_results);
        return array_values($final_results);
    }
    
    /**
     * Posta kodlarını paralel olarak geocode eder (optimize edilmiş)
     */
    private static function geocodePostcodesParallelOptimized($addresses) {
        $multi_handle = curl_multi_init();
        $curl_handles = array();
        $results = array();
        
        // Her adres için posta kodu çıkar ve paralel istek hazırla
        foreach ($addresses as $index => $addr) {
            $address = $addr['address'];
            $postcode = self::extractPostcodeOptimized($address);
            
            if (!$postcode) {
                // Posta kodu yok - başarısız olarak işaretle
                $results[$index] = array(
                    'address' => $address,
                    'lat' => null,
                    'lon' => null,
                    'found' => false,
                    'proxy_used' => 'NO_POSTCODE',
                    'response_info' => 'No postcode found'
                );
                continue;
            }
            
            // Posta kodu cache'den kontrol et
            $cached_result = self::checkPostcodeCache($postcode);
            if ($cached_result !== null) {
                $results[$index] = array(
                    'address' => $address,
                    'lat' => $cached_result['lat'],
                    'lon' => $cached_result['lon'],
                    'found' => $cached_result['found'],
                    'proxy_used' => 'POSTCODE_CACHED',
                    'response_info' => 'Postcode from cache'
                );
                continue;
            }
            
            // Cache'de yok - paralel istek hazırla
            $ch = self::createCurlHandle($postcode, self::getNextProxy());
            if ($ch) {
                curl_multi_add_handle($multi_handle, $ch);
                $curl_handles[$index] = array(
                    'handle' => $ch,
                    'address' => $address,
                    'postcode' => $postcode
                );
            }
        }
        
        // Paralel istekleri çalıştır
        if (!empty($curl_handles)) {
            $running = null;
            do {
                curl_multi_exec($multi_handle, $running);
                curl_multi_select($multi_handle);
            } while ($running > 0);
            
            // Sonuçları işle
            foreach ($curl_handles as $index => $handle_info) {
                $ch = $handle_info['handle'];
                $address = $handle_info['address'];
                $postcode = $handle_info['postcode'];
                
                $response = curl_multi_getcontent($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                $result_found = false;
                $lat = null;
                $lon = null;
                
                if ($response && $http_code === 200) {
                    $data = json_decode($response, true);
                    if ($data && is_array($data) && count($data) > 0) {
                        $lat = floatval($data[0]['lat']);
                        $lon = floatval($data[0]['lon']);
                        $result_found = true;
                    }
                }
                
                $results[$index] = array(
                    'address' => $address,
                    'lat' => $lat,
                    'lon' => $lon,
                    'found' => $result_found,
                    'proxy_used' => $result_found ? 'POSTCODE_SUCCESS' : 'POSTCODE_FAILED',
                    'response_info' => $result_found ? "Postcode '$postcode' geocoded successfully" : "Postcode '$postcode' failed"
                );
                
                // Cache'e kaydet
                self::savePostcodeToCache($postcode, $lat, $lon, $result_found);
                
                curl_multi_remove_handle($multi_handle, $ch);
                curl_close($ch);
            }
        }
        
        curl_multi_close($multi_handle);
        
        // Performans istatistikleri
        $success_count = 0;
        $cache_count = 0;
        $failed_count = 0;
        
        foreach ($results as $result) {
            if ($result['proxy_used'] === 'POSTCODE_CACHED') {
                $cache_count++;
            } elseif ($result['found']) {
                $success_count++;
            } else {
                $failed_count++;
            }
        }
        
        $total = count($results);
        self::logPerformance("Posta kodu sonuçları: $total toplam, $cache_count cache, $success_count yeni başarı, $failed_count başarısız");
        
        return $results;
    }
    
    /**
     * Tam adresleri paralel olarak geocode eder
     */
    private static function geocodeFullAddressesParallel($addresses) {
        $multi_handle = curl_multi_init();
        $curl_handles = array();
        $results = array();
        
        // Her adres için paralel istek hazırla
        foreach ($addresses as $index => $addr) {
            $address = $addr['address'];
            $ch = self::createCurlHandle($address, self::getNextProxy());
            if ($ch) {
                curl_multi_add_handle($multi_handle, $ch);
                $curl_handles[$index] = array(
                    'handle' => $ch,
                    'address' => $address
                );
            }
        }
        
        // Paralel istekleri çalıştır
        if (!empty($curl_handles)) {
            $running = null;
            do {
                curl_multi_exec($multi_handle, $running);
                curl_multi_select($multi_handle);
            } while ($running > 0);
            
            // Sonuçları işle
            foreach ($curl_handles as $index => $handle_info) {
                $ch = $handle_info['handle'];
                $address = $handle_info['address'];
                
                $response = curl_multi_getcontent($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                $result_found = false;
                $lat = null;
                $lon = null;
                
                if ($response && $http_code === 200) {
                    $data = json_decode($response, true);
                    if ($data && is_array($data) && count($data) > 0) {
                        $lat = floatval($data[0]['lat']);
                        $lon = floatval($data[0]['lon']);
                        $result_found = true;
                    }
                }
                
                $results[$index] = array(
                    'address' => $address,
                    'lat' => $lat,
                    'lon' => $lon,
                    'found' => $result_found,
                    'proxy_used' => $result_found ? 'FULL_ADDRESS_SUCCESS' : 'FULL_ADDRESS_FAILED',
                    'response_info' => $result_found ? 'Full address geocoded' : 'Full address failed'
                );
                
                curl_multi_remove_handle($multi_handle, $ch);
                curl_close($ch);
            }
        }
        
        curl_multi_close($multi_handle);
        
        // Performans istatistikleri
        $success_count = 0;
        $failed_count = 0;
        
        foreach ($results as $result) {
            if ($result['found']) {
                $success_count++;
            } else {
                $failed_count++;
            }
        }
        
        $total = count($results);
        self::logPerformance("Tam adres sonuçları: $total toplam, $success_count başarı, $failed_count başarısız");
        
        return $results;
    }
    
    /**
     * Posta kodu cache'den kontrol eder
     */
    private static function checkPostcodeCache($postcode) {
        try {
            $postcode_hash = md5(strtolower($postcode));
            $cache_query = "SELECT lat, lon, found FROM geocode_cache WHERE address_hash = :hash LIMIT 1";
            $cache_command = Yii::app()->db->createCommand($cache_query);
            $cache_command->bindParam(':hash', $postcode_hash);
            $cache_result = $cache_command->queryRow();
            
            if ($cache_result) {
                $lat = $cache_result['lat'] ? floatval($cache_result['lat']) : null;
                $lon = $cache_result['lon'] ? floatval($cache_result['lon']) : null;
                $found = (bool)$cache_result['found'];
                
                // Cache'de varsa direkt döndür - artık kontrol etme
                return array('lat' => $lat, 'lon' => $lon, 'found' => $found);
            }
        } catch (Exception $e) {
            // Cache hatası - devam et
        }
        
        return null; // Cache'de yok
    }
    
    /**
     * Posta kodu sonucunu cache'e kaydeder
     */
    private static function savePostcodeToCache($postcode, $lat, $lon, $found) {
        try {
            $postcode_hash = md5(strtolower($postcode));
            $insert_query = "INSERT INTO geocode_cache (address, address_hash, lat, lon, found) 
                            VALUES (:address, :hash, :lat, :lon, :found) 
                            ON DUPLICATE KEY UPDATE 
                            lat = VALUES(lat), lon = VALUES(lon), found = VALUES(found), updated_at = NOW()";
            
            $insert_command = Yii::app()->db->createCommand($insert_query);
            $found_value = $found ? 1 : 0;
            
            $insert_command->bindParam(':address', $postcode);
            $insert_command->bindParam(':hash', $postcode_hash);
            $insert_command->bindParam(':lat', $lat);
            $insert_command->bindParam(':lon', $lon);
            $insert_command->bindParam(':found', $found_value);
            
            $insert_command->execute();
        } catch (Exception $e) {
            // Cache kaydetme hatası - devam et
        }
    }
    
    /**
     * Adresin son 2 kelimesini (posta kodu) çıkarır (optimize edilmiş)
     */
    private static function extractPostcodeOptimized($address) {
        $address = trim($address);
        if (empty($address)) {
            return null;
        }
        
        // Virgül, nokta gibi işaretleri temizle
        $cleaned = preg_replace('/[,\.;]/', ' ', $address);
        $words = preg_split('/\s+/', trim($cleaned));
        
        if (count($words) >= 2) {
            // Son 2 kelimeyi al
            $last_word = $words[count($words) - 1];
            $second_last_word = $words[count($words) - 2];
            
            // UK posta kodu formatını kontrol et (örn: SW1A 1AA, M1 1AA, B1 1AA)
            $postcode = $second_last_word . ' ' . $last_word;
            
            // Basit UK posta kodu format kontrolü
            if (preg_match('/^[A-Z]{1,2}\d{1,2}\s+\d[A-Z]{2}$/i', $postcode)) {
                return strtoupper(trim($postcode)); // UK formatında ise büyük harfle döndür
            }
            
            // Format uymazsa da son 2 kelimeyi dene
            return trim($postcode);
        }
        
        return null;
    }
    
    /**
     * Posta kodlarını paralel olarak geocode eder
     */
    private static function geocodePostcodesParallel($addresses) {
        $multi_handle = curl_multi_init();
        $curl_handles = array();
        $results = array();
        
        foreach ($addresses as $index => $address_data) {
            $address = trim($address_data['address']);
            
            if (strlen($address) < 3) {
                $results[$index] = [
                    'address' => $address,
                    'lat' => null,
                    'lon' => null,
                    'found' => false,
                    'proxy_used' => null,
                    'response_info' => 'Adres çok kısa'
                ];
                continue;
            }
            
            $proxy = self::getNextProxy();
            $ch = self::createCurlHandle($address, $proxy);
            
            if ($ch) {

             
                $curl_handles[$index] = array(
                    'handle' => $ch,
                    'address' => $address,
                    'attempt' => 1
                );
                $proxy_info[$index] = $proxy;
                curl_multi_add_handle($multi_handle, $ch);
            } else {
             
                // Başarısız sonuç kaydet
                $results[$index] = [
                    'address' => $address,
                    'lat' => null,
                    'lon' => null,
                    'found' => false,
                    'proxy_used' => $proxy,
                    'response_info' => 'Curl handle oluşturulamadı'
                ];
            }
        }
        
        // Paralel istekleri çalıştır
        $running = null;
        do {
            curl_multi_exec($multi_handle, $running);
            curl_multi_select($multi_handle);
        } while ($running > 0);
        
        // Sonuçları topla
        $retry_needed = array();
        
        foreach ($curl_handles as $index => $handle_info) {
            $ch = $handle_info['handle'];
            $original_address = $handle_info['address'];
            $attempt = $handle_info['attempt'];
            
            $response = curl_multi_getcontent($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
            $curl_error = curl_error($ch);
            
            $proxy_used = $proxy_info[$index];
            $result = null;
            $response_info = "HTTP: $http_code, Süre: " . round($total_time, 2) . "s";
            


            
            if ($response && $http_code === 200) {
                $data = json_decode($response, true);
                $json_error = json_last_error();
                
                if ($json_error !== JSON_ERROR_NONE) {
                    $response_info .= ", Sonuç: JSON Hatası (" . json_last_error_msg() . ")";
                } else {
                    if (is_array($data)) {
                        if (count($data) > 0) {
                            if (isset($data[0]['lat']) && isset($data[0]['lon'])) {
                                $result = [
                                    'lat' => floatval($data[0]['lat']),
                                    'lon' => floatval($data[0]['lon'])
                                ];
                                $response_info .= ", Sonuç: Bulundu";
                            } else {
                                $response_info .= ", Sonuç: Lat/Lon eksik";
                            }
                        } else {
                            $response_info .= ", Sonuç: Boş array";
                        }
                    } else {
                        $response_info .= ", Sonuç: Array değil (" . gettype($data) . ")";
                    }
                    
                    // Boş sonuç ve ilk deneme ise, posta kodu ile tekrar dene
                    if ($attempt == 1 && $result === null) {
                        $postcode = self::extractPostcode($original_address);
                        if ($postcode && $postcode != $original_address) {
                            // Önce posta kodu cache'de var mı kontrol et
                            $postcode_hash = md5(strtolower($postcode));
                            $postcode_cached = false;
                            
                            try {
                                $cache_query = "SELECT lat, lon, found FROM geocode_cache WHERE address_hash = :hash LIMIT 1";
                                $cache_command = Yii::app()->db->createCommand($cache_query);
                                $cache_command->bindParam(':hash', $postcode_hash);
                                $postcode_cache_result = $cache_command->queryRow();
                                
                                if ($postcode_cache_result) {
                                    // Posta kodu cache'de bulundu - ama başarılı mı kontrol et
                                    $pc_lat = $postcode_cache_result['lat'] ? floatval($postcode_cache_result['lat']) : null;
                                    $pc_lon = $postcode_cache_result['lon'] ? floatval($postcode_cache_result['lon']) : null;
                                    $pc_found = (bool)$postcode_cache_result['found'];
                                    
                                    // Eğer başarılı cache kaydı varsa kullan
                                    if ($pc_found && $pc_lat !== null && $pc_lon !== null) {
                                        $result = array(
                                            'lat' => $pc_lat,
                                            'lon' => $pc_lon
                                        );
                                        $postcode_cached = true;
                                        $response_info .= ", Posta kodu cache'den bulundu";
                                    } else {
                                        // Cache'de var ama başarısız - tekrar dene
                                        // postcode_cached = false kalacak, retry_needed'e eklenecek
                                    }
                                }
                            } catch (Exception $e) {
                                // Cache hatası - devam et
                            }
                            
                            if (!$postcode_cached) {
                                $retry_needed[$index] = array(
                                    'address' => $postcode,
                                    'original_address' => $original_address,
                                    'proxy' => $proxy_used
                                );
                            }
                        }
                    }
                }
            } else {
                $response_info .= ", Sonuç: Hata";
                if ($curl_error) {
                    $response_info .= " (" . $curl_error . ")";
                }
            }
            
            // Sonucu kaydet (retry varsa üzerine yazılacak)
            $results[$index] = [
                'address' => $original_address,
                'lat' => $result ? $result['lat'] : null,
                'lon' => $result ? $result['lon'] : null,
                'found' => $result !== null,
                'proxy_used' => $proxy_used,
                'response_info' => $response_info
            ];
            
            curl_multi_remove_handle($multi_handle, $ch);
            curl_close($ch);
        }
        
        // Posta kodu ile tekrar deneme
        if (!empty($retry_needed)) {
            $retry_handles = array();
            $retry_proxy_info = array();
            
            foreach ($retry_needed as $index => $retry_info) {
                $ch = self::createCurlHandle($retry_info['address'], $retry_info['proxy']);
                if ($ch) {
                    $retry_handles[$index] = array(
                        'handle' => $ch,
                        'address' => $retry_info['address'],
                        'original_address' => $retry_info['original_address'],
                        'attempt' => 2
                    );
                    $retry_proxy_info[$index] = $retry_info['proxy'];
                    curl_multi_add_handle($multi_handle, $ch);
                }
            }
            
            // Retry isteklerini çalıştır
            $running = null;
            do {
                curl_multi_exec($multi_handle, $running);
                curl_multi_select($multi_handle);
            } while ($running > 0);
            
            // Retry sonuçlarını topla
            foreach ($retry_handles as $index => $handle_info) {
                $ch = $handle_info['handle'];
                $postcode_address = $handle_info['address'];
                $original_address = $handle_info['original_address'];
                
                $response = curl_multi_getcontent($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $total_time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
                $curl_error = curl_error($ch);
                
                $proxy_used = $retry_proxy_info[$index];
                $result = null;
                $response_info = "HTTP: $http_code, Süre: " . round($total_time, 2) . "s (Posta kodu ile)";
                
                if ($response && $http_code === 200) {
                    $data = json_decode($response, true);
                    $json_error = json_last_error();
                    
                    if ($json_error !== JSON_ERROR_NONE) {
                        $response_info .= ", Sonuç: Posta kodu JSON Hatası (" . json_last_error_msg() . ")";
                    } else if (is_array($data) && count($data) > 0 && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                        $result = [
                            'lat' => floatval($data[0]['lat']),
                            'lon' => floatval($data[0]['lon'])
                        ];
                        $response_info .= ", Sonuç: Posta kodu ile bulundu";
                    } else {
                        $response_info .= ", Sonuç: Posta kodu ile de bulunamadı";
                    }
                }
                
                // Başarılı ise sonucu güncelle
                if ($result) {
                    $results[$index] = [
                        'address' => $original_address,
                        'lat' => $result['lat'],
                        'lon' => $result['lon'],
                        'found' => true,
                        'proxy_used' => $proxy_used,
                        'response_info' => $response_info
                    ];
                    
                    // Posta kodu sonucunu cache'e kaydet
                    try {
                        $postcode_hash = md5(strtolower($postcode_address));
                        $insert_query = "INSERT INTO geocode_cache (address, address_hash, lat, lon, found) 
                                        VALUES (:address, :hash, :lat, :lon, :found) 
                                        ON DUPLICATE KEY UPDATE 
                                        lat = VALUES(lat), lon = VALUES(lon), found = VALUES(found), updated_at = NOW()";
                        
                        $insert_command = Yii::app()->db->createCommand($insert_query);
                        $lat_value = $result['lat'];
                        $lon_value = $result['lon'];
                        $found_value = 1;
                        
                        $insert_command->bindParam(':address', $postcode_address);
                        $insert_command->bindParam(':hash', $postcode_hash);
                        $insert_command->bindParam(':lat', $lat_value);
                        $insert_command->bindParam(':lon', $lon_value);
                        $insert_command->bindParam(':found', $found_value);
                        
                        $insert_command->execute();
                    } catch (Exception $e) {
                        // Cache kaydetme hatası - devam et
                    }
                } else {
                    // Başarısız ise sadece response_info'yu güncelle
                    $results[$index]['response_info'] .= " -> " . $response_info;
                    
                    // Başarısız posta kodu sonucunu da cache'e kaydet
                    try {
                        $postcode_hash = md5(strtolower($postcode_address));
                        $insert_query = "INSERT INTO geocode_cache (address, address_hash, lat, lon, found) 
                                        VALUES (:address, :hash, :lat, :lon, :found) 
                                        ON DUPLICATE KEY UPDATE 
                                        found = VALUES(found), updated_at = NOW()";
                        
                        $insert_command = Yii::app()->db->createCommand($insert_query);
                        $lat_value = null;
                        $lon_value = null;
                        $found_value = 0;
                        
                        $insert_command->bindParam(':address', $postcode_address);
                        $insert_command->bindParam(':hash', $postcode_hash);
                        $insert_command->bindParam(':lat', $lat_value);
                        $insert_command->bindParam(':lon', $lon_value);
                        $insert_command->bindParam(':found', $found_value);
                        
                        $insert_command->execute();
                    } catch (Exception $e) {
                        // Cache kaydetme hatası - devam et
                    }
                }
                
                curl_multi_remove_handle($multi_handle, $ch);
                curl_close($ch);
            }
        }
        
        curl_multi_close($multi_handle);
        
        // Index sırasına göre sırala
        ksort($results);
        $final_results = array_values($results);
        
        return $final_results;
    }
    
    private static function geocodeBatch($addresses) {
        $batch_size = 10;
        $batches = array_chunk($addresses, $batch_size, true);
        
        $results = [];
        foreach ($batches as $batch_index => $batch) {
            $batch_results = self::geocodeParallel($batch);
            $results = array_merge($results, $batch_results);
            
            // Batch'ler arası kısa bekleme
            if (count($batches) > 1) {
                usleep(100000); // 100ms
            }
        }
        
        return $results;
    }
    
    private static function searchWithProxy($address) {
        $max_retries = 2; // Daha az deneme
        $retry_count = 0;
        
        while ($retry_count < $max_retries) {
            $proxy = self::getNextProxy();
            $result = self::makeRequest($address, $proxy);
            
            if ($result !== null) {
                return $result;
            }
            
            $retry_count++;
            // Başarısız olursa çok kısa bekleme
            if ($retry_count < $max_retries) {
                usleep(50000); // 50ms bekleme
            }
        }
        
        return null;
    }
    
    private static function getNextProxy() {
        $proxy = self::$proxies[self::$proxy_index];
        self::$proxy_index = (self::$proxy_index + 1) % count(self::$proxies);
        return $proxy;
    }
    
    private static function createCurlHandle($address, $proxy_string) {
        // Proxy formatı: host:port:username:password
        $proxy_parts = explode(':', $proxy_string);
        if (count($proxy_parts) != 4) {
            return null;
        }
        
        $proxy_host = trim($proxy_parts[0]);
        $proxy_port = trim($proxy_parts[1]);
        $proxy_user = trim($proxy_parts[2]);
        $proxy_pass = trim($proxy_parts[3]);
        
        $url = 'https://nominatim.openstreetmap.org/search?format=json&q=' . urlencode($address) . '&limit=1';
       
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Proxy için daha uzun timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); // Proxy bağlantısı için daha uzun
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        
        // Proxy ayarları - HTTP proxy
        curl_setopt($ch, CURLOPT_PROXY, $proxy_host . ':' . $proxy_port);
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy_user . ':' . $proxy_pass);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        
        // Proxy için ek ayarlar
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true); // HTTPS için tunnel
        curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); // Basic auth
        
        // Debug için verbose mode
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        
        return $ch;
    }
    
    private static function makeRequest($address, $proxy_string) {
        $ch = self::createCurlHandle($address, $proxy_string);
        if (!$ch) {
            return null;
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($response === false || $http_code !== 200) {
            return null;
        }
        
        $data = json_decode($response, true);
        if (!$data || !is_array($data) || count($data) == 0) {
            return null;
        }
        
        return [
            'lat' => floatval($data[0]['lat']),
            'lon' => floatval($data[0]['lon'])
        ];
    }
    
    /**
     * ESKİ SİSTEM UYUMLULUĞU: Eski geocodeAddresses çağrıları için
     * @deprecated Yeni sistemde geocodeUniqueClients kullanın
     */
    public static function geocodeAddresses($addresses) {
        
        // Eski format -> yeni format dönüşümü
        $clients_data = array();
        foreach ($addresses as $index => $addr) {
            $clients_data[] = array(
                'clientname' => 'Address_' . $index, // Dummy client name
                'address' => $addr['address']
            );
        }
        
        // Yeni sistemi çağır
        $results = self::geocodeUniqueClients($clients_data);
        
        // Yeni format -> eski format dönüşümü
        $legacy_results = array();
        foreach ($results as $result) {
            $legacy_results[] = array(
                'address' => $result['address'],
                'lat' => $result['lat'],
                'lon' => $result['lon'],
                'found' => $result['found'],
                'proxy_used' => $result['proxy_used'],
                'response_info' => $result['response_info']
            );
        }
        
        return $legacy_results;
    }

    /**
     * Cache tablosundaki başarısız kayıtları yeniden geocoding yap ve güncelle
     */
    public static function refreshFailedCacheEntries($limit = 50) {
        try {
            // Tablo var mı kontrol et
            $table_check = Yii::app()->db->createCommand("SHOW TABLES LIKE 'geocode_cache'")->queryScalar();
            if (!$table_check) {
                return false;
            }
            
            $connection = Yii::app()->db;
            
            // Başarısız kayıtları bul (found=0 veya lat/lon null/empty)
            $failed_records = $connection->createCommand("
                SELECT id, address, address_hash 
                FROM geocode_cache 
                WHERE found = 0 OR lat IS NULL OR lon IS NULL OR lat = '' OR lon = ''
                ORDER BY updated_at ASC
                LIMIT :limit
            ")->bindParam(':limit', $limit, PDO::PARAM_INT)->queryAll();
            
            if (empty($failed_records)) {
                return true;
            }
            
            $updated_count = 0;
            $success_count = 0;
            
            foreach ($failed_records as $record) {
                $address = $record['address'];
                $record_id = $record['id'];
                
                // Tek adres için geocoding yap
                $result = self::searchWithProxy($address);
                
                if ($result && isset($result['lat']) && isset($result['lon']) && 
                    $result['lat'] !== null && $result['lon'] !== null) {
                    
                    // Başarılı sonucu cache'e güncelle
                    $update_result = $connection->createCommand("
                        UPDATE geocode_cache 
                        SET lat = :lat, lon = :lon, found = 1, updated_at = NOW()
                        WHERE id = :id
                    ")->execute(array(
                        ':lat' => $result['lat'],
                        ':lon' => $result['lon'],
                        ':id' => $record_id
                    ));
                    
                    if ($update_result) {
                        $success_count++;
                    }
                } else {
                    // Yine başarısız - updated_at'i güncelle ki bir süre tekrar denenmeyecek
                    $connection->createCommand("
                        UPDATE geocode_cache 
                        SET updated_at = NOW()
                        WHERE id = :id
                    ")->execute(array(':id' => $record_id));
                }
                
                $updated_count++;
                
                // API rate limiting için kısa bekleme
                usleep(200000); // 0.2 saniye
            }
            
            return true;
            
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Cache tablosundaki başarısız kayıt sayısını döndürür
     */
    public static function getFailedCacheCount() {
        try {
            $table_check = Yii::app()->db->createCommand("SHOW TABLES LIKE 'geocode_cache'")->queryScalar();
            if (!$table_check) {
                return 0;
            }
            
            $count = Yii::app()->db->createCommand("
                SELECT COUNT(*) 
                FROM geocode_cache 
                WHERE found = 0 OR lat IS NULL OR lon IS NULL OR lat = '' OR lon = ''
            ")->queryScalar();
            
            return intval($count);
            
        } catch (Exception $e) {
            return 0;
        }
    }
    

}

?> 