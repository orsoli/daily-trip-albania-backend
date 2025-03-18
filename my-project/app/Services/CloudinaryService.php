<?php
namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    /**
     * Upload a file to Cloudinary
     * @param obj $file
     * @return $uploadedFile
     */
    public function upload($file, $folder = '', $transformation = [])
    {
        try {

            // Get Original Name
             $originalName = $file->getClientOriginalName();

            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'transformation' => $transformation
            ]);


            return [
                'url' => $uploadedFile->getSecurePath(),
                'caption' => $originalName,
                'public_id' => $uploadedFile->getPublicId()
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            return null;
        }
    }

   /**
     * Delete a file from Cloudinary
     * @param string $publicId
     * @return bool
     */
    public function destroy($publicId)
    {
        try {
            $result = Cloudinary::destroy($publicId);

            if ($result['result'] !== 'ok') {
                Log::error("Cloudinary destroy failed for: " . $publicId);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary destroy error: ' . $e->getMessage());
            return false;
        }
    }
}
