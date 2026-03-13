CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    display_name VARCHAR(150),
    avatar VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    INDEX idx_users_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE permissions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE role_permissions (
    role_id INT UNSIGNED NOT NULL,
    permission_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (role_id, permission_id),
    CONSTRAINT fk_rp_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE,
    CONSTRAINT fk_rp_perm FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE user_roles (
    user_id INT UNSIGNED NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (user_id, role_id),
    CONSTRAINT fk_ur_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_ur_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE teams (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE team_members (
    team_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    role_in_team VARCHAR(100),
    PRIMARY KEY (team_id, user_id),
    CONSTRAINT fk_tm_team FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    CONSTRAINT fk_tm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE organizations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    organization_id INT UNSIGNED NOT NULL,
    project_key VARCHAR(20) NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    lead_user_id INT UNSIGNED,
    project_type ENUM('scrum','kanban') DEFAULT 'scrum',
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uk_project_key (project_key),
    INDEX idx_project_org (organization_id),
    CONSTRAINT fk_proj_org FOREIGN KEY (organization_id) REFERENCES organizations(id),
    CONSTRAINT fk_proj_lead FOREIGN KEY (lead_user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE project_members (
    project_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (project_id, user_id),
    CONSTRAINT fk_pm_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE,
    CONSTRAINT fk_pm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_pm_role FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE issue_types (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(100),
    color VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE priorities (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    level INT DEFAULT 0,
    color VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE statuses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    category ENUM('todo','in_progress','done') DEFAULT 'todo',
    color VARCHAR(20),
    order_no INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE workflows (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    project_id INT UNSIGNED NOT NULL,
    CONSTRAINT fk_wf_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE workflow_transitions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    workflow_id INT UNSIGNED NOT NULL,
    from_status_id INT UNSIGNED NOT NULL,
    to_status_id INT UNSIGNED NOT NULL,
    transition_name VARCHAR(150),
    CONSTRAINT fk_wt_workflow FOREIGN KEY (workflow_id) REFERENCES workflows(id) ON DELETE CASCADE,
    CONSTRAINT fk_wt_from FOREIGN KEY (from_status_id) REFERENCES statuses(id),
    CONSTRAINT fk_wt_to FOREIGN KEY (to_status_id) REFERENCES statuses(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE issues (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    issue_key VARCHAR(30) NOT NULL,
    issue_type_id INT UNSIGNED NOT NULL,
    summary VARCHAR(255) NOT NULL,
    description MEDIUMTEXT,
    priority_id INT UNSIGNED,
    status_id INT UNSIGNED,
    reporter_id INT UNSIGNED,
    assignee_id INT UNSIGNED,
    story_points DECIMAL(5,2),
    due_date DATE,
    parent_issue_id INT UNSIGNED NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    UNIQUE KEY uk_issue_key (issue_key),
    INDEX idx_issue_project (project_id),
    CONSTRAINT fk_issue_project FOREIGN KEY (project_id) REFERENCES projects(id),
    CONSTRAINT fk_issue_type FOREIGN KEY (issue_type_id) REFERENCES issue_types(id),
    CONSTRAINT fk_issue_priority FOREIGN KEY (priority_id) REFERENCES priorities(id),
    CONSTRAINT fk_issue_status FOREIGN KEY (status_id) REFERENCES statuses(id),
    CONSTRAINT fk_issue_reporter FOREIGN KEY (reporter_id) REFERENCES users(id),
    CONSTRAINT fk_issue_assignee FOREIGN KEY (assignee_id) REFERENCES users(id),
    CONSTRAINT fk_issue_parent FOREIGN KEY (parent_issue_id) REFERENCES issues(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE issue_labels (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    color VARCHAR(20)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE issue_label_map (
    issue_id INT UNSIGNED NOT NULL,
    label_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (issue_id, label_id),
    CONSTRAINT fk_il_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_il_label FOREIGN KEY (label_id) REFERENCES issue_labels(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE issue_watchers (
    issue_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (issue_id, user_id),
    CONSTRAINT fk_iw_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_iw_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE comments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    comment_text MEDIUMTEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,
    INDEX idx_comment_issue (issue_id),
    CONSTRAINT fk_comment_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_comment_user FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE attachments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    file_name VARCHAR(255),
    file_path VARCHAR(255),
    file_size INT,
    uploaded_by INT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_att_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_att_user FOREIGN KEY (uploaded_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE issue_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    issue_id INT UNSIGNED NOT NULL,
    field_changed VARCHAR(100),
    old_value TEXT,
    new_value TEXT,
    changed_by INT UNSIGNED,
    changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_hist_issue (issue_id),
    CONSTRAINT fk_hist_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE,
    CONSTRAINT fk_hist_user FOREIGN KEY (changed_by) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE boards (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_id INT UNSIGNED NOT NULL,
    name VARCHAR(150),
    board_type ENUM('scrum','kanban') DEFAULT 'scrum',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_board_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE sprints (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    board_id INT UNSIGNED NOT NULL,
    name VARCHAR(150),
    goal TEXT,
    start_date DATE,
    end_date DATE,
    state ENUM('planned','active','closed') DEFAULT 'planned',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sprint_board FOREIGN KEY (board_id) REFERENCES boards(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE sprint_issues (
    sprint_id INT UNSIGNED NOT NULL,
    issue_id INT UNSIGNED NOT NULL,
    added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (sprint_id, issue_id),
    CONSTRAINT fk_si_sprint FOREIGN KEY (sprint_id) REFERENCES sprints(id) ON DELETE CASCADE,
    CONSTRAINT fk_si_issue FOREIGN KEY (issue_id) REFERENCES issues(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE notifications (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    issue_id INT UNSIGNED NULL,
    type VARCHAR(100),
    title VARCHAR(255),
    message TEXT,
    is_read TINYINT(1) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_notif_user (user_id),
    CONSTRAINT fk_notif_user FOREIGN KEY (user_id) REFERENCES users(id),
    CONSTRAINT fk_notif_issue FOREIGN KEY (issue_id) REFERENCES issues(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE issues

-- Board loading (project + status)
ADD INDEX idx_project_status (project_id, status_id),

-- My tasks view
ADD INDEX idx_assignee_status (assignee_id, status_id),

-- Reporter lookup
ADD INDEX idx_reporter (reporter_id),

-- Sprint filtering via parent project
ADD INDEX idx_project_priority (project_id, priority_id),

-- Due date filtering
ADD INDEX idx_due_date (due_date),

-- Parent/epic hierarchy
ADD INDEX idx_parent (parent_issue_id),

-- Created date sorting
ADD INDEX idx_created (created_at);

ALTER TABLE sprint_issues
ADD INDEX idx_issue (issue_id);

ALTER TABLE comments
ADD INDEX idx_issue_created (issue_id, created_at);

ALTER TABLE issue_history
ADD INDEX idx_issue_date (issue_id, changed_at);


ALTER TABLE notifications

-- Fast unread panel
ADD INDEX idx_user_read (user_id, is_read),

-- Notification sorting
ADD INDEX idx_user_created (user_id, created_at);


ALTER TABLE project_members
ADD INDEX idx_user_project (user_id, project_id);


ALTER TABLE issue_label_map
ADD INDEX idx_label_issue (label_id, issue_id);


ALTER TABLE issue_watchers
ADD INDEX idx_user_watch (user_id, issue_id);


ALTER TABLE sprints
ADD INDEX idx_board_state (board_id, state);