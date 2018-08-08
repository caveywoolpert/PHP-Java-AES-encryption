import javax.crypto.Cipher;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;

import java.util.Base64;

public class Java_AES_Cipher {

    private static String CIPHER_NAME = "AES/CBC/PKCS5PADDING";

    /**
 *      * Decrypt data using AES Cipher (CBC) with 128 bit key
 *           *
 *                * @param key - key to use should be 16 bytes long (128 bits)
 *                     * @param data - encrypted data with iv at the end separate by :
 *                          * @return decrypted data string
 *                               */

    public static String decrypt(String key, String data) {
        try {

            String[] parts = data.split(":");

            IvParameterSpec iv = new IvParameterSpec(Base64.getDecoder().decode(parts[1]));
            SecretKeySpec skeySpec = new SecretKeySpec(key.getBytes("UTF-8"), "AES");

            Cipher cipher = Cipher.getInstance(Java_AES_Cipher.CIPHER_NAME);
            cipher.init(Cipher.DECRYPT_MODE, skeySpec, iv);

            byte[] decodedEncryptedData = Base64.getDecoder().decode(parts[0]);

            byte[] original = cipher.doFinal(decodedEncryptedData);

            return new String(original);
        } catch (Exception ex) {
            ex.printStackTrace();
        }

        return null;
    }

}
