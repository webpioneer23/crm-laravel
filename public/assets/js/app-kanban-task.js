/**
 * App Kanban
 */

'use strict';

(async function () {
  let boards;
  const kanbanSidebar = document.querySelector('.kanban-update-item-sidebar'),
    kanbanWrapper = document.querySelector('.kanban-wrapper'),
    commentEditor = document.querySelector('.comment-editor'),
    kanbanAddNewBoard = document.querySelector('.kanban-add-new-board'),
    kanbanAddNewInput = [].slice.call(document.querySelectorAll('.kanban-add-board-input')),
    kanbanAddBoardBtn = document.querySelector('.kanban-add-board-btn'),
    datePicker = document.querySelector('#due-date'),
    select2 = $('.select2'), // ! Using jquery vars due to select2 jQuery dependency
    assetsPath = document.querySelector('html').getAttribute('data-assets-path'),
    updateBtn = document.getElementById('update-btn');

  let prefixUrl = '/public';
  if (location.hostname === 'localhost' || location.hostname === '127.0.0.1') {
    prefixUrl = '';
  }
  console.log({ prefixUrl });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Init kanban Offcanvas
  const kanbanOffcanvas = new bootstrap.Offcanvas(kanbanSidebar);

  // Get kanban data
  // const kanbanResponse = await fetch(assetsPath + 'json/kanban.json');
  const kanbanResponse = await fetch(prefixUrl + '/task-board');
  if (!kanbanResponse.ok) {
    console.error('error', kanbanResponse);
  }
  boards = await kanbanResponse.json();
  boards = boards.map(board => ({
    ...board,
    id: `board-${board.id}`
  }));

  // datepicker init
  if (datePicker) {
    datePicker.flatpickr({
      monthSelectorType: 'static',
      altInput: true,
      altFormat: 'j F, Y',
      dateFormat: 'Y-m-d'
    });
  }

  async function deleteAjax(url) {
    try {
      const response = await fetch(url, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      if (!response.ok) {
        return false;
      }

      const data = await response.json();
      return true;
    } catch (error) {
      return false;
    }
  }

  async function postAjax(url, requestBody, isPut = false) {
    try {
      const response = await fetch(url, {
        method: isPut ? 'PUT' : 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(requestBody)
      });
      if (!response.ok) {
        return false;
      }

      const data = await response.json();
      return data;
    } catch (error) {
      console.log('error->> ', error);
    }
  }

  function swalSuccess() {
    // Swal.fire({
    //   icon: 'success',
    //   title: 'Success',
    //   showConfirmButton: false,
    //   timer: 1500,
    //   customClass: {
    //     confirmButton: 'btn btn-primary'
    //   },
    //   buttonsStyling: false
    // });
    console.log('success');
  }

  function swalError() {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      showConfirmButton: false,
      timer: 1500,
      customClass: {
        confirmButton: 'btn btn-primary'
      },
      buttonsStyling: false
    });
  }

  //! TODO: Update Event label and guest code to JS once select removes jQuery dependency
  // select2
  if (select2.length) {
    function renderLabels(option) {
      if (!option.id) {
        return option.text;
      }
      var $badge = "<div class='badge " + $(option.element).data('color') + " rounded-pill'> " + option.text + '</div>';
      return $badge;
    }

    select2.each(function () {
      var $this = $(this);
      $this.wrap("<div class='position-relative'></div>").select2({
        placeholder: 'Select',
        dropdownParent: $this.parent(),
        templateResult: renderLabels,
        templateSelection: renderLabels,
        escapeMarkup: function (es) {
          return es;
        }
      });
    });
  }

  // Comment editor
  if (commentEditor) {
    new Quill(commentEditor, {
      modules: {
        toolbar: '.comment-toolbar'
      },
      placeholder: 'Write a Comment... ',
      theme: 'snow'
    });
  }

  // Render board dropdown
  function renderBoardDropdown() {
    return (
      "<div class='dropdown'>" +
      "<i class='dropdown-toggle ti ti-dots-vertical cursor-pointer' id='board-dropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></i>" +
      "<div class='dropdown-menu dropdown-menu-end' aria-labelledby='board-dropdown'>" +
      "<a class='dropdown-item delete-board btn-danger' href='javascript:void(0)'> <i class='ti ti-trash ti-xs' me-1></i> <span class='align-middle'>Delete</span></a>" +
      // "<a class='dropdown-item' href='javascript:void(0)'><i class='ti ti-edit ti-xs' me-1></i> <span class='align-middle'>Rename</span></a>" +
      // "<a class='dropdown-item' href='javascript:void(0)'><i class='ti ti-archive ti-xs' me-1></i> <span class='align-middle'>Archive</span></a>" +
      '</div>' +
      '</div>'
    );
  }
  // Render item dropdown
  function renderDropdown() {
    return (
      "<div class='dropdown kanban-tasks-item-dropdown'>" +
      "<i class='dropdown-toggle ti ti-dots-vertical' id='kanban-tasks-item-dropdown' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'></i>" +
      "<div class='dropdown-menu dropdown-menu-end' aria-labelledby='kanban-tasks-item-dropdown'>" +
      // "<a class='dropdown-item' href='javascript:void(0)'>Copy task link</a>" +
      "<a class='dropdown-item' href='javascript:void(0)'>Duplicate task</a>" +
      "<a class='dropdown-item delete-task' href='javascript:void(0)'>Delete</a>" +
      '</div>' +
      '</div>'
    );
  }
  // Render header
  function renderHeader(color, text) {
    return (
      "<div class='d-flex justify-content-between flex-wrap align-items-center mb-2 pb-1'>" +
      "<div class='item-badges'> " +
      '</div>' +
      '</div>' +
      renderDropdown() +
      '</div>'
    );
    return (
      "<div class='d-flex justify-content-between flex-wrap align-items-center mb-2 pb-1'>" +
      "<div class='item-badges'> " +
      "<div class='badge rounded-pill bg-label-" +
      color +
      "'> " +
      text +
      '</div>' +
      '</div>' +
      renderDropdown() +
      '</div>'
    );
  }

  // Render avatar
  function renderAvatar(images, pullUp, size, margin, members) {
    var $transition = pullUp ? ' pull-up' : '',
      $size = size ? 'avatar-' + size + '' : '',
      member = members == undefined ? ' ' : members.split(',');

    return images == undefined
      ? ' '
      : images
          .split(',')
          .map(function (img, index, arr) {
            var $margin = margin && index !== arr.length - 1 ? ' me-' + margin + '' : '';

            return (
              "<div class='avatar " +
              $size +
              $margin +
              "'" +
              "data-bs-toggle='tooltip' data-bs-placement='top'" +
              "title='" +
              member[index] +
              "'" +
              '>' +
              "<img src='" +
              assetsPath +
              'img/avatars/' +
              img +
              "' alt='Avatar' class='rounded-circle " +
              $transition +
              "'>" +
              '</div>'
            );
          })
          .join(' ');
  }

  // Render footer
  function renderFooter(users, listings, appraisals, contacts, contracts) {
    return (
      "<div class='d-flex align-items-center flex-wrap mt-2 pt-1'>" +
      "<div class='item-badges demo-inline-spacing'>" +
      (users ? `<div class='badge rounded-pill bg-label-success'>User</div>` : '') +
      (listings ? `<div class='badge rounded-pill bg-label-danger'>Listing</div>` : '') +
      (appraisals ? `<div class='badge rounded-pill bg-label-warning'>Appraisal</div>` : '') +
      (contacts ? `<div class='badge rounded-pill bg-label-info'>Contact</div>` : '') +
      (contracts ? `<div class='badge rounded-pill bg-label-primary'>Contract</div>` : '') +
      '</div></div>'
    );

    return (
      "<div class='d-flex justify-content-between align-items-center flex-wrap mt-2 pt-1'>" +
      "<div class='d-flex'> <span class='d-flex align-items-center me-2'><i class='ti ti-paperclip ti-xs me-1'></i>" +
      "<span class='attachments'>" +
      attachments +
      '</span>' +
      "</span> <span class='d-flex align-items-center ms-1'><i class='ti ti-message-dots ti-xs me-1'></i>" +
      '<span> ' +
      comments +
      ' </span>' +
      '</span></div>' +
      "<div class='avatar-group d-flex align-items-center assigned-avatar'>" +
      renderAvatar(assigned, true, 'xs', null, members) +
      '</div>' +
      '</div>'
    );
  }
  // Init kanban
  const kanban = new jKanban({
    element: '.kanban-wrapper',
    gutter: '15px',
    widthBoard: '250px',
    dragItems: true,
    boards: boards,
    dragBoards: true,
    addItemButton: true,
    buttonContent: '+ Add Item',
    itemAddOptions: {
      enabled: true, // add a button to board for easy item creation
      content: '+ Add New Item', // text or html content of the board button
      class: 'kanban-title-button btn', // default class of the button
      footer: false // position the button on footer
    },
    click: function (el) {
      // click task card, open sidebar modal
      let element = el;
      let taskId = element.getAttribute('data-eid');
      let users = element.getAttribute('data-users');
      let listings = element.getAttribute('data-listings');
      let appraisals = element.getAttribute('data-appraisals');
      let contacts = element.getAttribute('data-contacts');
      let contracts = element.getAttribute('data-contracts');
      users = users.split(',');
      listings = listings.split(',');
      appraisals = appraisals.split(',');
      contacts = contacts.split(',');
      contracts = contracts.split(',');

      let title = taskId ? element.querySelector('.kanban-text').textContent : element.textContent;
      taskId = taskId.split('-');
      // date = element.getAttribute('data-due-date'),
      // dateObj = new Date(),
      // year = dateObj.getFullYear(),
      // dateToUse = date
      //   ? date + ', ' + year
      //   : dateObj.getDate() + ' ' + dateObj.toLocaleString('en', { month: 'long' }) + ', ' + year,
      // label = element.getAttribute('data-badge-text'),
      // avatars = element.getAttribute('data-assigned');

      // Show kanban offcanvas
      kanbanOffcanvas.show();

      // To get data on sidebar
      kanbanSidebar.querySelector('#title').value = title;
      kanbanSidebar.querySelector('#task-id').value = taskId[1];
      $('#users').val(users).trigger('change');
      $('#listings').val(listings).trigger('change');
      $('#appraisals').val(appraisals).trigger('change');
      $('#contacts').val(contacts).trigger('change');
      $('#contracts').val(contracts).trigger('change');
      // kanbanSidebar.querySelector('#due-date').nextSibling.value = dateToUse;

      // ! Using jQuery method to get sidebar due to select2 dependency
      // $('.kanban-update-item-sidebar').find(select2).val(label).trigger('change');

      // Remove & Update assigned
      // kanbanSidebar.querySelector('.assigned').innerHTML = '';
      // kanbanSidebar
      //   .querySelector('.assigned')
      //   .insertAdjacentHTML(
      //     'afterbegin',
      //     renderAvatar(avatars, false, 'xs', '1', el.getAttribute('data-members')) +
      //       "<div class='avatar avatar-xs ms-1'>" +
      //       "<span class='avatar-initial rounded-circle bg-label-secondary'><i class='ti ti-plus ti-xs text-heading'></i></span>" +
      //       '</div>'
      //   );
    },

    buttonClick: function (el, boardId) {
      // click task card
      const addNew = document.createElement('form');
      addNew.setAttribute('class', 'new-item-form');
      addNew.innerHTML =
        '<div class="mb-3">' +
        '<textarea class="form-control add-new-item" rows="2" placeholder="Add Content" autofocus required></textarea>' +
        '</div>' +
        '<div class="mb-3">' +
        '<button type="submit" class="btn btn-primary btn-sm me-2">Add</button>' +
        '<button type="button" class="btn btn-label-secondary btn-sm cancel-add-item">Cancel</button>' +
        '</div>';
      kanban.addForm(boardId, addNew);

      addNew.addEventListener('submit', async function (e) {
        e.preventDefault();

        const newTask = await postAjax(prefixUrl + '/task', {
          name: e.target[0].value,
          boardId
        });

        if (!newTask) {
          swalError();
          return;
        }
        swalSuccess();

        kanban.addElement(boardId, {
          title: "<span class='kanban-text'>" + e.target[0].value + '</span>',
          id: 'task-' + newTask.id
        });

        // add dropdown in new boards
        const kanbanText = [].slice.call(
          document.querySelectorAll('.kanban-board[data-id=' + boardId + '] .kanban-text')
        );
        kanbanText.forEach(function (e) {
          e.insertAdjacentHTML('beforebegin', renderDropdown());
        });

        // prevent sidebar to open onclick dropdown buttons of new tasks
        const newTaskDropdown = [].slice.call(document.querySelectorAll('.kanban-item .kanban-tasks-item-dropdown'));
        if (newTaskDropdown) {
          newTaskDropdown.forEach(function (e) {
            e.addEventListener('click', function (el) {
              el.stopPropagation();
            });
          });
        }

        // delete tasks for new boards
        const deleteTask = [].slice.call(
          document.querySelectorAll('.kanban-board[data-id=' + boardId + '] .delete-task')
        );
        deleteTask.forEach(function (e) {
          e.addEventListener('click', async function () {
            const id = this.closest('.kanban-item').getAttribute('data-eid');
            const taskIdArr = id.split('-');
            if (taskIdArr.length >= 2) {
              const taskId = taskIdArr[1];
              const taskDeleted = await deleteAjax(prefixUrl + '/task/' + taskId);
              if (taskDeleted) {
                swalSuccess();
                kanban.removeElement(id);
              } else {
                swalError();
                return;
              }
            }
          });
        });
        addNew.remove();
      });

      // Remove form on clicking cancel button
      addNew.querySelector('.cancel-add-item').addEventListener('click', function (e) {
        addNew.remove();
      });
    },
    dragendBoard: async function (el) {
      // move board
      const kanbanBoardList = document.querySelectorAll('.kanban-board');
      const boardIds = [];
      for (let index = 0; index < kanbanBoardList.length; index++) {
        const element = kanbanBoardList[index];
        const boardIdArr = element.getAttribute('data-id').split('-');
        boardIds.push(boardIdArr[1]);
      }
      await postAjax(prefixUrl + '/task-board-order', { boardIds });
    },
    dropEl: async function (el, target, source, sibling) {
      // move task
      let diffBoard = false;

      const targetId = $(target).closest('div.kanban-board').attr('data-id');
      const sourceId = $(source).closest('div.kanban-board').attr('data-id');

      if (targetId === sourceId) {
        diffBoard = false;
      } else {
        diffBoard = true;
      }

      const kanbanTaskList = $(target).children('.kanban-item');
      const taskIds = [];
      for (let index = 0; index < kanbanTaskList.length; index++) {
        const element = kanbanTaskList[index];
        const taskIdArr = $(element).data('eid').split('-');
        taskIds.push(taskIdArr[1]);
      }

      const boardId = targetId.split('-')[1];

      await postAjax(prefixUrl + '/task-order', { taskIds, diffBoard, boardId });
    }
  });

  // Kanban Wrapper scrollbar
  if (kanbanWrapper) {
    new PerfectScrollbar(kanbanWrapper);
  }

  const kanbanContainer = document.querySelector('.kanban-container'),
    kanbanTitleBoard = [].slice.call(document.querySelectorAll('.kanban-title-board')),
    kanbanItem = [].slice.call(document.querySelectorAll('.kanban-item'));

  // Render custom items
  if (kanbanItem) {
    kanbanItem.forEach(function (el) {
      console.log('kanbanitem', el);
      const element = "<span class='kanban-text'>" + el.textContent + '</span>';
      let img = '';
      if (el.getAttribute('data-image') !== null) {
        img =
          "<img class='img-fluid rounded mb-2' src='" +
          assetsPath +
          'img/elements/' +
          el.getAttribute('data-image') +
          "'>";
      }
      el.textContent = '';

      const users = el.getAttribute('data-users');
      const listings = el.getAttribute('data-listings');
      const appraisals = el.getAttribute('data-appraisals');
      const contacts = el.getAttribute('data-contacts');
      const contracts = el.getAttribute('data-contracts');

      if (el.getAttribute('data-badge') !== undefined && el.getAttribute('data-badge-text') !== undefined) {
        el.insertAdjacentHTML(
          'afterbegin',
          renderHeader(el.getAttribute('data-badge'), el.getAttribute('data-badge-text')) + img + element
        );
      }
      // dev need
      if (
        el.getAttribute('data-comments') !== undefined ||
        el.getAttribute('data-due-date') !== undefined ||
        el.getAttribute('data-assigned') !== undefined
      ) {
        el.insertAdjacentHTML('beforeend', renderFooter(users, listings, appraisals, contacts, contracts));
      }
    });
  }

  // To initialize tooltips for rendered items
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // prevent sidebar to open onclick dropdown buttons of tasks
  const tasksItemDropdown = [].slice.call(document.querySelectorAll('.kanban-tasks-item-dropdown'));
  if (tasksItemDropdown) {
    tasksItemDropdown.forEach(function (e) {
      e.addEventListener('click', function (el) {
        el.stopPropagation();
      });
    });
  }

  // Toggle add new input and actions add-new-btn
  if (kanbanAddBoardBtn) {
    kanbanAddBoardBtn.addEventListener('click', () => {
      kanbanAddNewInput.forEach(el => {
        el.value = '';
        el.classList.toggle('d-none');
      });
    });
  }

  // Render add new inline with boards
  if (kanbanContainer) {
    kanbanContainer.appendChild(kanbanAddNewBoard);
  }

  // Makes kanban title editable for rendered boards
  if (kanbanTitleBoard) {
    kanbanTitleBoard.forEach(function (elem) {
      elem.addEventListener('mouseenter', function () {
        this.contentEditable = 'true';
      });

      elem.addEventListener('focusout', async function (e) {
        const newTitle = $(this).text();
        const id = this.closest('.kanban-board').getAttribute('data-id');
        const boardId = id.split('-')[1];
        await postAjax(prefixUrl + '/task-board/' + boardId, { title: newTitle }, true);
      });

      // Appends delete icon with title
      elem.insertAdjacentHTML('afterend', renderBoardDropdown());
    });
  }

  // To delete Board for rendered boards
  const deleteBoards = [].slice.call(document.querySelectorAll('.delete-board'));
  if (deleteBoards) {
    deleteBoards.forEach(function (elem) {
      elem.addEventListener('click', async function () {
        const id = this.closest('.kanban-board').getAttribute('data-id');
        const result = await deleteAjax(prefixUrl + '/task-board/' + id);
        if (result) {
          kanban.removeBoard(id);
          swalSuccess();
        } else {
          swalError();
        }
      });
    });
  }

  // Delete task for rendered boards
  const deleteTask = [].slice.call(document.querySelectorAll('.delete-task'));
  if (deleteTask) {
    deleteTask.forEach(function (e) {
      e.addEventListener('click', async function () {
        const id = this.closest('.kanban-item').getAttribute('data-eid');
        const taskIdArr = id.split('-');
        if (taskIdArr.length >= 2) {
          const taskId = taskIdArr[1];
          const taskDeleted = await deleteAjax(prefixUrl + '/task/' + taskId);
          if (taskDeleted) {
            swalSuccess();
            kanban.removeElement(id);
          } else {
            swalError();
            return;
          }
        }
      });
    });
  }

  // Cancel btn add new input
  const cancelAddNew = document.querySelector('.kanban-add-board-cancel-btn');
  if (cancelAddNew) {
    cancelAddNew.addEventListener('click', function () {
      kanbanAddNewInput.forEach(el => {
        el.classList.toggle('d-none');
      });
    });
  }

  // Add new board
  if (kanbanAddNewBoard) {
    kanbanAddNewBoard.addEventListener('submit', async function (e) {
      e.preventDefault();
      const thisEle = this,
        value = thisEle.querySelector('.form-control').value;

      const newBoard = await postAjax(prefixUrl + '/task-board', { title: value });
      if (!newBoard) {
        swalError();
        return;
      }

      swalSuccess();
      const id = `board-${newBoard.id}`;
      kanban.addBoards([
        {
          id: id,
          title: value
        }
      ]);

      // Adds delete board option to new board, delete new boards & updates data-order
      const kanbanBoardLastChild = document.querySelectorAll('.kanban-board:last-child')[0];
      if (kanbanBoardLastChild) {
        const header = kanbanBoardLastChild.querySelector('.kanban-title-board');
        header.insertAdjacentHTML('afterend', renderBoardDropdown());
        console.log('data order');
        // To make newly added boards title editable
        kanbanBoardLastChild.querySelector('.kanban-title-board').addEventListener('mouseenter', function () {
          this.contentEditable = 'true';
        });

        kanbanBoardLastChild.querySelector('.kanban-title-board').addEventListener('focusout', async function (e) {
          const newTitle = $(this).text();
          const id = this.closest('.kanban-board').getAttribute('data-id');
          const boardId = id.split('-')[1];
          await postAjax(prefixUrl + '/task-board/' + boardId, { title: newTitle }, true);
        });
      }

      // Add delete event to delete newly added boards
      const deleteNewBoards = kanbanBoardLastChild.querySelector('.delete-board');
      if (deleteNewBoards) {
        deleteNewBoards.addEventListener('click', async function () {
          const id = this.closest('.kanban-board').getAttribute('data-id');
          const deleteResult = await deleteAjax(prefixUrl + '/task-board/' + id);
          if (!deleteResult) {
            swalError();
            return;
          }
          swalSuccess();
          kanban.removeBoard(id);
        });
      }

      // Remove current append new add new form
      if (kanbanAddNewInput) {
        kanbanAddNewInput.forEach(el => {
          el.classList.add('d-none');
        });
      }

      // To place inline add new btn after clicking add btn
      if (kanbanContainer) {
        kanbanContainer.appendChild(kanbanAddNewBoard);
      }
    });
  }

  // Clear comment editor on close
  kanbanSidebar.addEventListener('hidden.bs.offcanvas', function () {
    // kanbanSidebar.querySelector('.ql-editor').firstElementChild.innerHTML = '';
  });

  // Re-init tooltip when offcanvas opens(Bootstrap bug)
  if (kanbanSidebar) {
    kanbanSidebar.addEventListener('shown.bs.offcanvas', function () {
      const tooltipTriggerList = [].slice.call(kanbanSidebar.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    });
  }

  if (updateBtn) {
    updateBtn.addEventListener('click', function () {
      console.log('form subvmit');
    });
  }
})();
