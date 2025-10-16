const navbar = document.getElementById("navbar");
      if (navbar) {
        window.addEventListener("scroll", () => {
          if (window.scrollY > 20) {
            navbar.classList.add("scrolled");
          } else {
            navbar.classList.remove("scrolled");
          }
        });
      }

      const fileInput = document.getElementById("file-input");
      const uploadArea = document.getElementById("upload-area");
      const uploadBtn = document.getElementById("upload-btn");
      const uploadedFilesSection = document.getElementById(
        "uploaded-files-section"
      );
      const fileList = document.getElementById("file-list");
      const submitHwBtn = document.getElementById("submit-hw-btn");

      if (uploadBtn)
        uploadBtn.addEventListener("click", () => fileInput.click());
      if (uploadArea)
        uploadArea.addEventListener("click", () => fileInput.click());

      if (uploadArea) {
        uploadArea.addEventListener("dragover", (e) => {
          e.preventDefault();
          uploadArea.style.borderColor = "var(--brand)";
          uploadArea.style.backgroundColor = "#f0f7ff";
        });

        uploadArea.addEventListener("dragleave", () => {
          uploadArea.style.borderColor = "var(--border)";
          uploadArea.style.backgroundColor = "#f8fafc";
        });

        uploadArea.addEventListener("drop", (e) => {
          e.preventDefault();
          uploadArea.style.borderColor = "var(--border)";
          uploadArea.style.backgroundColor = "#f8fafc";
          if (e.dataTransfer.files.length > 0)
            handleFiles(e.dataTransfer.files);
        });
      }

      if (fileInput) {
        fileInput.addEventListener("change", () => {
          if (fileInput.files.length > 0) handleFiles(fileInput.files);
        });
      }

      let currentFiles = [];

      function handleFiles(files) {
        for (const file of files) {
          currentFiles.push(file);
        }
        renderFileList();
      }

      function renderFileList() {
        fileList.innerHTML = "";
        if (currentFiles.length > 0) {
          currentFiles.forEach((file, index) => {
            const fileItem = document.createElement("li");
            fileItem.className = "file-item";
            fileItem.innerHTML = `
              <span class="file-name">${file.name}</span>
              <span class="delete-file-btn" data-index="${index}" title="حذف الملف">
                <i class="fas fa-trash"></i>
              </span>
            `;
            fileList.appendChild(fileItem);
          });
          uploadedFilesSection.style.display = "block";
        } else {
          uploadedFilesSection.style.display = "none";
        }
      }

      fileList.addEventListener("click", (e) => {
        if (e.target.closest(".delete-file-btn")) {
          const index = e.target.closest(".delete-file-btn").dataset.index;
          currentFiles.splice(index, 1);
          renderFileList();
        }
      });

      if (submitHwBtn) {
        submitHwBtn.addEventListener("click", () => {
          if (currentFiles.length === 0) {
            alert("الرجاء اختيار ملف واحد على الأقل قبل الحفظ.");
            return;
          }

          submitHwBtn.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> جاري الحفظ...';
          submitHwBtn.disabled = true;

          setTimeout(() => {
            alert("تم حفظ التسليم بنجاح! ستتم إعادتك إلى صفحة الواجب.");
            window.location.href = "homework.html";
          }, 1500);
        });
      }