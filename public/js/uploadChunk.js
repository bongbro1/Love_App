/**
 * Upload file theo dạng chia nhỏ (chunked upload)
 * @param {File} file - File cần upload
 * @param {Object} options - Cấu hình upload
 * @param {string} options.url - URL xử lý upload trên server
 * @param {number} [options.chunkSize=5*1024*1024] - Kích thước mỗi chunk (mặc định 5MB)
 * @param {Object} [options.extraData={}] - Dữ liệu gửi kèm (vd: unlock_at, type)
 * @param {function(progress:number)} [options.onProgress] - Callback cập nhật tiến độ (0-100)
 * @returns {Promise<object>} - Trả về phản hồi JSON từ server (chunk cuối)
 */
async function uploadFileInChunks(file, options) {
    const {
        url,
        chunkSize = 5 * 1024 * 1024,
        extraData = {},
        onProgress = () => {}
    } = options;

    if (!file) throw new Error("Chưa chọn file để upload");
    if (!url) throw new Error("Thiếu URL upload");

    const totalChunks = Math.ceil(file.size / chunkSize);
    const fileName = Date.now() + "_" + file.name;

    let lastResponse = null; // ✅ lưu phản hồi cuối cùng từ server

    for (let i = 0; i < totalChunks; i++) {
        const start = i * chunkSize;
        const end = Math.min(file.size, start + chunkSize);
        const chunk = file.slice(start, end);

        const formData = new FormData();
        formData.append('file', chunk);
        formData.append('file_name', fileName);
        formData.append('chunk_index', i);
        formData.append('total_chunks', totalChunks);

        // Gửi thêm dữ liệu phụ (nếu có)
        for (const key in extraData) {
            formData.append(key, extraData[key]);
        }

        try {
            const res = await $.ajax({
                url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false
            });

            lastResponse = res; // ✅ Lưu lại phản hồi server
            const percent = Math.round(((i + 1) / totalChunks) * 100);
            onProgress(percent);
        } catch (err) {
            console.error("Lỗi khi upload chunk:", i, err);
            throw err;
        }
    }

    return lastResponse; // ✅ Trả về phản hồi chunk cuối cùng (thường là { success: true, file: ... })
}

// ✅ Xuất hàm để dùng ở file khác
if (typeof window !== 'undefined') {
    window.uploadFileInChunks = uploadFileInChunks;
}
